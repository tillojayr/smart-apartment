<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ElectricVariable;
use App\Models\Room;
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
                        $request->owner->bill = $bill;
                        $request->owner->volts = $voltage;
                        $request->owner->current = $current;
                        $request->owner->consumed = $consumed;
                        $request->owner->save();

                        $data[] = [
                            'room_id' => 0,
                            'owner_id' => $request->owner->id,
                            'bill' => $bill,
                            'volts' => $voltage,
                            'current' => $current ?? 0,
                            'consumed' => $consumed,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                    else{
                        $data[] = [
                            'room_id' => $roomId,
                            'owner_id' => $request->owner->id,
                            'bill' => $bill,
                            'volts' => $voltage,
                            'current' => $current,
                            'consumed' => $consumed,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];

                        $room = Room::find($roomId);

                        if($room){
                            $room->update([
                                'bill' => $bill,
                                'volts' => $voltage,
                                'current' => $current,
                                'consumed' => $consumed
                            ]);
                        }
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
}
