<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BattlerController extends Controller
{
    public function index()
    {
        return response()->json("Oi");
    }
}