<?php

namespace App\Interfaces\Controllers;

use Illuminate\Http\Request;

interface IUsageController
{
    public function getUsageData(Request $request);
}
