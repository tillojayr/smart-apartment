<?php

namespace App\Http\Controllers;

use App\Interfaces\Controllers\IBudgetController;
use Illuminate\Http\Request;

class BudgetController extends Controller implements IBudgetController
{
    public function setRoomBudget(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'room_id' => 'required|integer',
            'amount' => 'required|numeric'
        ]);

        // Implementation will go here
        return response()->json([
            'success' => true,
            'data' => $validated
        ]);
    }
}
