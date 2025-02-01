<?php

namespace App\Http\Controllers\Api;

use App\Events\SwitchControlEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;

class SwitchController extends Controller
{
    public function index(Request $request)
    {
        $message = [
            "room" => $request->room_id,
            "relay_1" => $request->relay_1,
            "relay_2" => $request->relay_2,
        ];

        event(new SwitchControlEvent($message));
    }
}