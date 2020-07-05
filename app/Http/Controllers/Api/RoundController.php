<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Round;
use App\Battle;
use App\Fighter;

class RoundController extends Controller
{   
    const dice20 = 20;
    public $human = null;
    public $orc = null;

    public function index()
    {   
        $rounds = Round::all();
        if(!$rounds->isEmpty())
            return response()->json($rounds,200);
        
        return response()->json('Nada encontrado',200);
    }

    public function create(Request $request, $battle_id)
    {   
        $data = $request->all();
        $battle = Battle::firstWhere('id',$battle_id);
        
        if(empty($battle))
            return response()->json("Battle id {$battle_id} not found",200);
        
        $round = Round::where('battles_id','=',$battle_id)->get();
        
        $this->human = Fighter::firstWhere('id',$battle->human_id);
        $this->orc   = Fighter::firstWhere('id',$battle->orc_id);
        
        $newRound = new Round;
        $newRound->round_number = 1;
        
        $inicialWin = $this->winInitial();

        //if($inicialWin === 'human')
        
        $attackHuman = $this->attack($this->human,$this->orc);
        $attackOrc = $this->attack($this->orc,$this->human);

        //$newRound->value_dice_human = Rand(1,6)
        //$newRound->value_dice_orc = Rand(1,8)
        $data[] = $attackHuman;
        array_push($data,$attackOrc);
        return $data;
        
    }

    public function attack($playerAttack,$playerDefense)
    {
        $diceAttack = rand(1,20);
        //Agilidade do lutador mais forca de ataque da arma
        $attack = $diceAttack + $playerAttack->agility + $playerAttack->weapon->attack;

        $diceConter = rand(1,20);
        //Agilidade do lutador mais forca de defesa da arma
        $defense = $diceConter + $playerDefense->agility + $playerDefense->weapon->attack;

        if($attack > $defense)
        {   
            $danger =  $this->createDanger($playerAttack,$playerDefense);
            $texto = [
                'Texto' => "{$playerDefense->specie} levou dano ataque={$attack}  defesa={$defense}",
                'Figther' => $playerDefense,
                'Danger' => $danger
            ];

            return response()->json($texto,200);
        }
        return "{$playerDefense->specie} nao levou dano ataque={$attack}  defesa={$defense}";
    }

    public function createDanger($playerAttack,$playerDefense)
    {
        if($playerAttack->specie === 'Human')
        {
            $diceDanger = rand(1,6);
            $totalDanger = $diceDanger + $playerAttack->force;
            $playerDefense->life -= $totalDanger; 
            $playerDefense->save();
            return $totalDanger;            
        }

        $diceDanger = rand(1,8);
        $totalDanger = $diceDanger + $playerAttack->force;
        $playerDefense->life -= $totalDanger; 
        $playerDefense->save();
        return $totalDanger;       
    }
    public function winInitial():string
    {
        do{
            $diceInitialHuman = rand(1,20);
            $diceInitialOrc   = rand(1,20);

            $valueInitialHuman = $diceInitialHuman + $this->human->agility;
            $valueInitialOrc = $diceInitialOrc     + $this->orc->agility;

        }while($valueInitialOrc === $valueInitialHuman);

        if($valueInitialOrc > $valueInitialHuman)
            return 'orc';
        
        return 'human';
    }
}
