<?php

namespace App;

use Esl\Repository\ESLModel;
use Illuminate\Database\Eloquent\Model;

class Cargo extends ESLModel
{
    protected $fillable = ['cargo_weight','cargo_quantity','destination','cargo_type','desc',
        'remarks','status','distance','bl_number','start'];

    public function cargoType()
    {
        return $this->hasOne(CargoType::class,'id','cargo_type');
    }
}


