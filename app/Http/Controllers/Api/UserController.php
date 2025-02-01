<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function owner(Request $request)
    {
        try{
            $ownerUsername = $request->username;
    
            $owner = User::where('username', $ownerUsername)->first();

            if (!$owner) {
                return response()->json(['message' => 'No data found'], 404);
            }

            return response()->json($owner, 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function tenant(Request $request)
    {
        $ownerId = $request->owner_id;
        $roomPassword = $request->password;

        try{
            $room = Room::where(['password' => $roomPassword, 'owner_id' => $ownerId])->first();

            if (!$room) {
                return response()->json(['message' => 'No data found'], 404);
            }

            return response()->json($room, 200);
        } catch(\Exception $e){
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
}