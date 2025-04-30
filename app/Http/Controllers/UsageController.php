<?php

namespace App\Http\Controllers;

use App\Interfaces\Controllers\IUsageController;
use Illuminate\Http\Request;

class UsageController extends Controller implements IUsageController
{
    public function getUsageData(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'room_id' => 'required|integer',
            'date_range' => 'sometimes|array'
        ]);

        // Implementation will go here
        return response()->json([
            'success' => true,
            'data' => $validated
        ]);
    }
}
