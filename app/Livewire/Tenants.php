<?php

namespace App\Livewire;

use App\Models\Room;
use Carbon\CarbonImmutable;
use Livewire\Component;

class Tenants extends Component
{
    public $room_number;
    public $tenant;
    public $contact_number;
    public $email;
    public $address;
    public $reminder_time;
    public $password;
    public $joined_at;
    public $room;
    public $tenantDetailsModal = false;
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
        $this->contact_number = $this->room->contact_number;
        $this->email = $this->room->email;
        $this->address = $this->room->address;
        $this->reminder_time = $this->room->reminder_time;
        $joined_at = CarbonImmutable::createFromFormat('Y-m-d H:i:s', $this->room->joined_at)->format('Y-m-d');
        $this->joined_at = $joined_at;

        $this->tenantDetailsModal = true;
    }

    public function closeTenantDetailModal()
    {
        $this->tenantDetailsModal = false;
    }

    public function save()
    {
        $this->room->room_number = $this->room_number;
        $this->room->tenant = $this->tenant;
        $this->room->password = $this->password;
        $this->room->joined_at = $this->joined_at;
        $this->room->contact_number = $this->contact_number;
        $this->room->email = $this->email;
        $this->room->address = $this->address;
        $this->room->reminder_time = $this->reminder_time;
        $this->room->save();
        $this->tenantDetailsModal = false;
        session()->flash('message', 'Saved Successfully');
    }
}
