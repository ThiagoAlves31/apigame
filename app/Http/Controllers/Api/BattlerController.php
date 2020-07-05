<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Battle;
use App\Fighter;
class BattlerController extends Controller
{
    public function index()
    {
        return response()->json(Battle::all(),200);
    }

    public function create(Request $request)
    {   
        $data = $request->all();
        $orc = $data['orc_id'];
        $human = $data['human_id'];

        if(!$this->validateFighters($human,$orc))
            return response()->json("Dados invalidos",400);
        
        $newBattle = new Battle;
        $newBattle->human_id = $human;
        $newBattle->orc_id = $orc;
        $newBattle->save();
        return response()->json(Battle::all(),200);
    }

    public function store(Request $request)
    {

    }

    public function show($id)
    {

    }

    public function update(Request $request,$id)
    {

    }

    public function destroy($id)
    {

    }

    private function validateFighters($human_id ,$orc_id)
    {
        $human = Fighter::where('id','=',$human_id)
            ->where('specie','=','human')->get();
        
        if($human->isEmpty()) return false;

        $human = Fighter::where('id','=',$orc_id)
            ->where('specie','=','orc')->get();
        
        if($human->isEmpty()) return false;

        return true;
    }
}
