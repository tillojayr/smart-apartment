<?php

namespace App\Interfaces\Controllers;

use Illuminate\Http\Request;

interface IBudgetController
{
    public function setRoomBudget(Request $request);
}
