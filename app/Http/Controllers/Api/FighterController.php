<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Fighter;

class FighterController extends Controller
{
    public function index()
    {   
        return response()->json(Fighter::all(),200);
    }

    public function store(Request $request)
    {   
        $data = $request->all();
        
        $newFigther = new Fighter;
        $newFigther->name = $data['name'];
        $newFigther->specie = $data['specie'];
        
        if($newFigther->name && $newFigther->specie)
        {   
            if(strtoupper($newFigther->specie) !== 'ORC' && strtoupper($newFigther->specie) !== 'HUMAN')
            {
                $error = ['Dados incorretos'];
                array_push($error,$request->all());
                return response()->json($error);
            }

            if(strtoupper($newFigther->specie) === 'ORC')
            {
                $newFigther->life = 20;
                $newFigther->force = 2;
                $newFigther->agility = 0;
                $newFigther->save();
            }

            $newFigther->life = 20;
            $newFigther->force = 1;
            $newFigther->agility = 2;
            $newFigther->save();

            return response()->json($newFigther);
        }
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
}
