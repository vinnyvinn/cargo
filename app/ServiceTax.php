<?php

namespace App;

use Esl\Repository\ESLModel;
use Illuminate\Database\Eloquent\Model;

class ServiceTax extends Model
{
    protected $table = 'TaxRate';
    protected $connection = 'sqlsrv2';
    protected $primaryKey = 'idTaxRate';
    public $timestamps = false;
    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = ['idTaxRate','Code','TaxRate','Description'];
}
