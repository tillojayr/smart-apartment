<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ElectricVariable;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChartDataController extends Controller
{
    public function getChartData(Request $request)
    {
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();
        $roomId = $request->room_id;
        $ownerId = $request->owner_id;

        $query = ElectricVariable::query()
            ->where('owner_id', $ownerId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at');

        if ($roomId != 0) {
            $query->where('room_id', $roomId);
        } else {
            $query->where('room_id', 0);
        }

        $data = $query->get();

        // return response()->json([$ownerId]);
        $voltageData = $data->map(function ($item) {
            return [
                'x' => $item->created_at->timestamp * 1000,
                'y' => (float) $item->volts
            ];
        })->values()->toArray();

        $currentData = $data->map(function ($item) {
            return [
                'x' => $item->created_at->timestamp * 1000,
                'y' => (float) $item->current
            ];
        })->values()->toArray();

        return response()->json([
            'voltage' => $voltageData,
            'current' => $currentData
        ]);
    }
}
