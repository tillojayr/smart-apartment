<?php

namespace App\Http\Controllers;

use App\Interfaces\Controllers\IControlController;
use Illuminate\Http\Request;

class ControlController extends Controller implements IControlController
{
    public function switchDevice(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'room_id' => 'required|integer',
            'relay' => 'required|string',
            'state' => 'required|string|in:on,off'
        ]);

        // Implementation will go here
        return response()->json([
            'success' => true,
            'data' => $validated
        ]);
    }
}
