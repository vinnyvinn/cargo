<?php

namespace App;

use Esl\Repository\ESLModel;
use Illuminate\Database\Eloquent\Model;

class InvNum extends Model
{
    protected $table = 'InvNum';
    protected $primaryKey = 'AutoIndex';
    protected $connection = 'sqlsrv2';
}
