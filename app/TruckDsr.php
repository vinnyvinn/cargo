<?php

namespace App;

use Esl\Repository\ESLModel;
use Illuminate\Database\Eloquent\Model;

class TruckDsr extends ESLModel
{
    protected $fillable = ['truck_id','title','description'];
}
