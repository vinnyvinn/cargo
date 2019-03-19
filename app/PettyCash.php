<?php

namespace App;

use Esl\Repository\ESLModel;
use Illuminate\Database\Eloquent\Model;

class PettyCash extends Model
{
    protected $fillable = ['quotation_id','employee_number','user_id','amount','deadline','reason','file_path'];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class,'quotation_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
