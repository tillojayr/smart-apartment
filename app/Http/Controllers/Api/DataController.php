<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    public function index(Request $request)
    {
        dd($request->owner);
    }
}