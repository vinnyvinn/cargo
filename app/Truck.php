<?php

namespace App;

use Esl\Repository\ESLModel;
use Illuminate\Database\Eloquent\Model;

class Truck extends ESLModel
{
    protected $fillable = ['bl_id','driver','driver_id','contact','buying','cost',
        'vehicle_no','qty','weight','good_condition','image_path','container_no',
        'date_loaded','date_offloaded','departure','arrival','current_location','return','remarks'];
}