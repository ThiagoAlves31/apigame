<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fighter extends Model
{   
    public $timestamps = false;

    protected $fillable = [
        'name', 'life','force','agility','specie',
    ];

    public function weapon(){
        return $this->hasOne(Weapon::class);
    }

    public function battles(){
        return $this->hasMany(Battle::class);
    }
}
