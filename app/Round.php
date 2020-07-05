<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{   
    protected $fillable = ['round_number', 'action',
    'value_dice_human', 'value_dice_orc'];
    
    public $timestamps = false;

    public function battle()
    {
        return $this->belongsTo(Battle::class);
    }
}
