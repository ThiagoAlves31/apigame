<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Battle extends Model
{
    protected $fillable = ['id'];

    public function rounds(){
        return $this->hasMany(Round::class);
    }
}
