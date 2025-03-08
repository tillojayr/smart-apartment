<?php

namespace App\Livewire;

use App\Models\Room;
use App\Models\User;
use Livewire\Component;

class VisualData extends Component
{
    public function render()
    {
        $owner = User::find(auth()->id());
        $rooms = Room::where(['owner_id' => auth()->id()])->get();

        return view('livewire.visual-data', [
            'rooms' => $rooms,
            'owner' => $owner
        ]);
    }
}
