<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weapon extends Model
{
    protected $fillable = [
        'description', 'attack','defense','dice','specie',
    ];

    public function figther()
    {
        return $this->belongsTo(Fighter::class);
    }
}
