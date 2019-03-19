<?php

namespace App;

use Esl\Repository\ESLModel;
use Illuminate\Database\Eloquent\Model;

class Quotation extends ESLModel
{
    protected $fillable = [ 'DCLink','approved_id','user_id','project_id','cargo_id',
        'type','inputCur','doc_ids','invoice_id','status'];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'DCLink','DCLink');
    }

    public function purchaseOrder()
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    public function pettyCash()
    {
        return $this->hasMany(PettyCash::class);
    }

    public function approvedBy()
    {
        return $this->hasOne(User::class,'id','approved_id');
    }

    public function services()
    {
        return $this->hasMany(QuotationService::class,'quotation_id','id');
    }

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function cargo()
    {
        return $this->hasOne(Cargo::class,'id','cargo_id');
    }

    public function remarks()
    {
        return $this->hasMany(Remarks::class, 'quotation_id','id');
    }

    public function docs()
    {
        return $this->hasMany(VesselDocs::class,'vessel_id','id');
    }

    public function dms()
    {
        return $this->hasOne(BillOfLanding::class,'quote_id','id');
    }
}
