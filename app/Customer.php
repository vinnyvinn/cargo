<?php

namespace App;

use Esl\Repository\ESLModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    protected $table = 'Client';
    protected $primaryKey = 'DCLink';
    protected $connection = 'sqlsrv2';
    public $timestamps = false;
    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = ['DCLink','Account','Physical1','iCurrencyID','Physical2','Email',
        'Contact_Person','Name','Telephone'];
}