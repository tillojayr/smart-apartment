<?php

namespace App\Http\Controllers\Api;

use App\Events\SwitchControlEvent;
use App\Http\Controllers\Controller;
use App\Models\Control;
use Illuminate\Http\Request;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SwitchController extends Controller
{
    public function index(Request $request)
    {
        try{
            $message = [
                "apartmentId" => $request->apartmentId,
                "relay" => $request->room_id . $request->relay,
                "state" => $request->state,
            ];

            // event(new SwitchControlEvent($message));

            $control = Control::where(['owner_id' => $request->apartmentId, 'room_id' => $request->room_id])->first();

            $relay = $request->relay == 'a' ? '1' : '2';
            $control->fill(['relay_' . $relay => $request->state]);
            $control->save();

            return response()->json([], 200);
        }
        catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function state(Request $request)
    {
        try {
            $roomId = $request->room_id;

            $status = Control::where(['owner_id' => $request->owner->id, 'room_id' => $roomId])->first();

            if (!$status) {
                return response()->json(['message' => 'No data found'], 404);
            }

            return response()->json($status, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
}
