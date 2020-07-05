<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Weapon;

class WeaponController extends Controller
{
    public function index()
    {
        $weapons = Weapon::all();
        if(!$weapons->isEmpty())
            return response()->json($weapons,200);
        
        return response()->json('Nada encontrado',200);
    }
}
