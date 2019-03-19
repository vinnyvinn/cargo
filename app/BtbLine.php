<?php

namespace App;

use Esl\Repository\ESLModel;
use Illuminate\Database\Eloquent\Model;

class BtbLine extends Model
{
    protected $table = '_btblInvoiceLines';
    protected $primaryKey = 'idInvoiceLines';
    protected $connection = 'sqlsrv2';
}
