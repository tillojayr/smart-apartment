<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Room;
use App\Models\Control;
use App\Events\SwitchControlEvent;

class ControlPanel extends Component
{
    public $outlet_switch = [];
    public $light_switch = [];

    public function mount()
    {
        $rooms = Room::with('control')->where(['owner_id' => auth()->id()])->get();
        foreach ($rooms as $room) {
            $this->outlet_switch[$room->id] = (bool) $room->control->relay_1;
            $this->light_switch[$room->id] = (bool) $room->control->relay_2;
        }
    }

    public function updatedOutletSwitch($value, $roomId)
    {
        try {
            $control = Control::where(['owner_id' => auth()->id(), 'room_id' => $roomId])->first();
            if ($control) {
                $control->relay_1 = $value ? 1 : 0;
                $control->save();

                $message = [
                    "apartmentId" => auth()->id(),
                    "relay" => $roomId . "a",
                    "state" => $value ? 1 : 0,
                ];

                event(new SwitchControlEvent($message));
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update outlet switch');
        }
    }

    public function updatedLightSwitch($value, $roomId)
    {
        try {
            $control = Control::where(['owner_id' => auth()->id(), 'room_id' => $roomId])->first();
            if ($control) {
                $control->relay_2 = $value ? 1 : 0;
                $control->save();

                $message = [
                    "apartmentId" => auth()->id(),
                    "relay" => $roomId . "b",
                    "state" => $value ? 1 : 0,
                ];

                event(new SwitchControlEvent($message));
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update light switch');
        }
    }

    public function render()
    {
        $rooms = Room::where(['owner_id' => auth()->id()])->get();

        return view('livewire.control-panel', [
            'rooms' => $rooms,
        ]);
    }

    public function changeFlagRoom($roomId, $flag){
        try {
            $control = Control::where(['owner_id' => auth()->id(), 'room_id' => $roomId])->first();
            if ($control) {
                $room = Room::findOrFail($roomId);
                $room->flag = $flag;
                $room->save();

                $control->relay_1 = 0;
                $control->relay_2 = 0;
                $control->save();

                $message = [
                    "apartmentId" => auth()->id(),
                    "relay" => $roomId . "a",
                    "state" => 0,
                ];

                event(new SwitchControlEvent($message));

                $message = [
                    "apartmentId" => auth()->id(),
                    "relay" => $roomId . "b",
                    "state" => 0,
                ];

                event(new SwitchControlEvent($message));

                if($flag == 1){
                    session()->flash('message', 'Room ' . $room->room_number . ' deactivated successfully');
                }else{
                    session()->flash('message', 'Room ' . $room->room_number . ' activated successfully');
                }
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to deactivate room');
        }
        return redirect()->to('/control-panel');
    }
}
