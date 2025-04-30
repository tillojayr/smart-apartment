<?php

namespace App\Interfaces\Controllers;

use Illuminate\Http\Request;

interface IControlController
{
    public function switchDevice(Request $request);
}
