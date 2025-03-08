<?php

namespace App\Livewire;

use App\Models\Room;
use App\Models\User;
use App\Models\ElectricVariable;
use Carbon\Carbon;
use Livewire\Component;

class VisualDataRoom extends Component
{
    public $roomId;
    public $room;
    public $isAdmin = false;
    public $totalConsumption = 0;
    public $totalBill = 0;
    public $averageVoltage = 0;
    public $averageCurrent = 0;
    public $chartData = [];
    public $startDate;
    public $endDate;

    public function mount($roomId)
    {
        $this->roomId = $roomId;
        $this->startDate = Carbon::now()->subHours(24)->format('Y-m-d\TH:i');
        $this->endDate = Carbon::now()->format('Y-m-d\TH:i');
        $this->loadChartData();

        if ($roomId == 0) {
            $this->isAdmin = true;
            $rooms = Room::where('owner_id', auth()->id())->get();
            $this->totalBill = $rooms->sum('bill');
            $this->totalConsumption = $rooms->sum('consumed');
            $this->averageVoltage = $rooms->avg('volts') ?? 0;
            $this->averageCurrent = $rooms->avg('current') ?? 0;
        } else {
            $this->room = Room::where([
                'owner_id' => auth()->id(),
                'id' => $roomId
            ])->firstOrFail();
        }
    }

    public function updateDateRange($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->loadChartData();
    }

    public function updated($property)
    {
        if ($property === 'startDate' || $property === 'endDate') {
            $this->loadChartData();
            $this->dispatch('chartDataUpdated', $this->chartData);
        }
    }

    protected function loadChartData()
    {
        $startDate = Carbon::parse($this->startDate);
        $endDate = Carbon::parse($this->endDate);

        $query = ElectricVariable::query()
            ->where('owner_id', auth()->id())
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at');

        if ($this->roomId != 0) {
            $query->where('room_id', $this->roomId);
        }
        else{
            $query->where('room_id', 0);
        }

        $data = $query->get();

        $voltageData = $data->map(function ($item) {
            $timestamp = $item->created_at->timestamp * 1000; // Convert to milliseconds
            return [
                'x' => $timestamp,
                'y' => (float) $item->volts // Ensure numeric value
            ];
        })->values()->toArray();

        $currentData = $data->map(function ($item) {
            $timestamp = $item->created_at->timestamp * 1000; // Convert to milliseconds
            return [
                'x' => $timestamp,
                'y' => (float) $item->current // Ensure numeric value
            ];
        })->values()->toArray();

        $this->chartData = [
            'voltage' => $voltageData,
            'current' => $currentData
        ];

        $this->dispatch('chartDataUpdated', $this->chartData);
    }

    public function render()
    {
        return view('livewire.visual-data-room');
    }
}
