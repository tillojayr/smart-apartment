<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ElectricVariable;
use App\Models\Room;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    public function index(Request $request)
    {        
        try {
            $roomIds = explode('+', $request->roomId);
            $voltages = explode('+', $request->voltage);
            $currents = explode('+', $request->current);
            $consumes = explode('+', $request->consumed);

            $data = [];
            DB::beginTransaction();
            for ($i = 0; $i < 5; $i++) {
                if ($voltages[$i] != "NAN") {
                    $roomId = $roomIds[$i];
                    $voltage = $voltages[$i];
                    $current = $currents[$i];
                    $consumed = $consumes[$i];

                    $bill = (float) $consumed * $request->owner->rate;

                    if($i == 0){
                        $ownerBill = $request->owner->bill + $bill;
                        $ownerConsumed = $request->owner->consumed + $consumed;

                        $request->owner->bill = $ownerBill;
                        $request->owner->volts = $voltage;
                        $request->owner->current = $current;
                        $request->owner->consumed = $ownerConsumed;
                        $request->owner->save();

                        $data[] = [
                            'room_id' => 0,
                            'owner_id' => $request->owner->id,
                            'bill' => $ownerBill,
                            'volts' => $voltage,
                            'current' => $current ?? 0,
                            'consumed' => $ownerConsumed,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                    else{
                        $room = Room::find($roomId);

                        $roomBill = $room->bill + $bill;
                        $roomConsumed = $room->consumed + $consumed;
                        
                        if($room){
                            $room->update([
                                'bill' => $roomBill,
                                'volts' => $voltage,
                                'current' => $current,
                                'consumed' => $roomConsumed
                            ]);
                        }

                        $data[] = [
                            'room_id' => $roomId,
                            'owner_id' => $request->owner->id,
                            'bill' => $roomBill,
                            'volts' => $voltage,
                            'current' => $current,
                            'consumed' => $roomConsumed,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];

                        $this->handleBudgetNotification($room, $roomBill);
                    }
                }
            }

            if ($data) {
                ElectricVariable::insert($data);
                DB::commit();
            } else {
                DB::rollBack();
            }

            return response()->json('Success', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json('Something went wrong!', 500);
        }
    }

    public function reminderTime(Request $request)
    {
        $owner_id = $request->input('apartmentId');
        $room_id = $request->input('room_id');
        $reminder_time = $request->input('reminder_time');

        try {
            $room = Room::where(['owner_id' => $owner_id, 'id' => $room_id])->first();
            $room->reminder_time = $reminder_time;
            $room->save();

            return response()->json('Success', 200);
        } catch (\Exception $e) {
            return response()->json('Something went wrong', 500);
        }
    }

    public function getReminderTime($room_id){
        try{
            $room = Room::findOrFail($room_id);
            $reminder_time = $room->reminder_time;
            return response()->json(['reminder_time' => $reminder_time], 200);
        } catch(\Exception $e){
            return response()->json('Something went wrong', 500);
        }
    }

    private function handleBudgetNotification($room, $roomBill)
    {
        $smsService = new SmsService();

        if ($room->budget_notification_flag1 == 0) {
            if ($roomBill >= 0.75 * $room->budget && $roomBill <= 0.85 * $room->budget) {
                $smsService->sendSms(
                    $room->contact_number,
                    "Warning: Your electricity bill is approaching the budget limit. Current bill: $roomBill"
                );
                $room->budget_notification_flag1 = 1;
                $room->save();
            }
        }

        if ($room->budget_notification_flag2 == 0) {
            if ($roomBill >= $room->budget) {
                $smsService->sendSms(
                    $room->contact_number,
                    "Alert: Your electricity bill has exceeded the budget limit. Current bill: $roomBill"
                );
                $room->budget_notification_flag2 = 1;
                $room->save();
            }
        }
    }
}
