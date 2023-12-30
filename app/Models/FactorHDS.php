<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactorHDS extends Model
{
    use HasFactory;
    protected $table = 'Shop.dbo.FactorHDS';
    protected $fillable = ['CompanyNo','SnChequeBook','SnAccBank','SnPeopel','SnFactor','FactorName','FactorCode'];
    protected $primaryKey = 'SerialNoHDS';
    function customer(){
       return $this->belongsTo(Peopels::class,'CustomerSn','PSN');
    }

}
