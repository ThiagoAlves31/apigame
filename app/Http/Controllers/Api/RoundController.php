<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Round;
use App\Battle;
use App\Fighter;

class RoundController extends Controller
{   
    public $human = null;
    public $orc = null;
    public $roundNumber = null;
    public $battle;
    public $battle_id;
    
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
        $this->battle = Battle::firstWhere('id',$battle_id);

        if(empty($this->battle))
            return response()->json("Battle id {$battle_id} not found",200);
        
        if($this->battle->win_id)
            return response()->json(["Status" => "Battle end","Battle" => $this->battle],200);

        $this->human = Fighter::firstWhere('id',$this->battle->human_id);
        $this->orc   = Fighter::firstWhere('id',$this->battle->orc_id);

        $round = Round::firstWhere('battles_id',$battle_id);
        if(!empty($round))
            $round = $round->orderBy('id', 'desc')->get();

        $this->roundNumber = empty($round) ? 1 : $round[0]['round_number'] + 1;

        $newRound = new Round;
        $newRound->round_number = $this->roundNumber;
        $newRound->battles_id = $battle_id;
        $newRound->init_life_human = $this->battle->human_life;
        $newRound->init_life_orc = $this->battle->orc_life;
        $newRound->save();
        
        $inicialWin = $this->winInitial();
        
        if($inicialWin === 'human'){

            $attackHuman = $this->attack($this->human,$this->orc);
            if($this->battle->orc_life > 0)
                $attackOrc = $this->attack($this->orc,$this->human);
        }else
        {   
            $attackOrc = $this->attack($this->orc,$this->human);
            if($this->battle->human_life > 0)
                $attackHuman = $this->attack($this->human,$this->orc);
        };

        $newRound->final_life_human = $this->battle->human_life;;
        $newRound->final_life_orc = $this->battle->orc_life;;
        $newRound->save();

        if($this->battle->human_life < 1 || $this->battle->orc_life < 1)
        {   
            $idWin = $this->battle->human_life > 0 ? $this->human->id : $this->orc->id;
            $specieWin = $this->battle->human_life > 0 ? $this->human->specie : $this->orc->specie;

            $this->battle->rounds = $newRound->round_number;
            $this->battle->win_id = $idWin;
            $this->battle->win = $specieWin;
            $this->battle->save();
            $this->refreshFigthers();

        }else{
            
            $this->battle->rounds = $newRound->round_number;
            $this->battle->save();
        }

        $data = ["Round" => $this->battle->rounds];
        
        if(isset($attackHuman))
            array_push($data,$attackHuman);

        if(isset($attackOrc))
            array_push($data,$attackOrc);

        array_push($data,$this->battle);
        return response()->json($data,200);
        
    }

    public function attack($playerAttack,$playerDefense)
    {   
        $diceAttack = rand(1,20);
        $attack = $diceAttack + $playerAttack->agility + $playerAttack->weapon->attack;

        $diceDefense = rand(1,20);
        $defense = $diceDefense + $playerDefense->agility + $playerDefense->weapon->attack;
        
        if($attack > $defense)
        {   
            $danger =  $this->createDanger($playerAttack,$playerDefense);
            return "{$playerDefense->specie} levou dano de {$danger}";
        }
        return "{$playerDefense->specie} nao levou dano. Se defendeu bem -> ataque={$attack}  defesa={$defense}";
    }

    public function createDanger($playerAttack,$playerDefense)
    {   
        $diceMax = $playerAttack->weapon->dice;

        $diceDanger = rand(1,$diceMax);
        $totalDanger = $diceDanger + $playerAttack->force;
        
        if($playerAttack->specie == 'Human')
            $this->battle->orc_life -= $totalDanger;
        
        if($playerAttack->specie == 'Orc')
            $this->battle->human_life -= $totalDanger;
        
        $this->battle->save();
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

    public function refreshFigthers()
    {
        if($this->battle->human_life > 0)
        {
            $this->human->wins++;
            $this->human->battles++;
            $this->human->save();

            $this->orc->loss++;
            $this->orc->battles++;
            $this->orc->save();

        }else{

            $this->human->loss++;
            $this->human->battles++;
            $this->human->save();

            $this->orc->wins++;
            $this->orc->battles++;
            $this->orc->save();
        } 
    }
}
