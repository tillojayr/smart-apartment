<?php

namespace App\Livewire;

use App\Models\Room;
use Livewire\Component;

class Tenants extends Component
{
    public $room_number;
    public $tenant;
    public $password;
    public $joined_at;
    public $room;
    public function render()
    {
        $rooms = Room::where(['owner_id' => Auth()->user()->id])->get();

        return view('livewire.tenants', ['rooms' => $rooms]);
    }

    public function tenantDetails($id)
    {
        $this->room = Room::find($id);

        $this->room_number = $this->room->room_number;
        $this->tenant = $this->room->tenant;
        $this->password = $this->room->password;
        $this->joined_at = $this->room->joined_at;
    }
}
