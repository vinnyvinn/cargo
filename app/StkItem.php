<?php

namespace App;

use Esl\Repository\ESLModel;
use Illuminate\Database\Eloquent\Model;

class StkItem extends Model
{
    protected $table = 'StkItem';
    protected $primaryKey = 'StockLink';
    protected $connection = 'sqlsrv2';
}
