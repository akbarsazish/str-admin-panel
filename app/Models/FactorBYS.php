<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactorBYS extends Model
{
    use HasFactory;
    protected $table = 'Shop.dbo.FactorBYS';
    protected $fillable = ['CompanyNo','SnChequeBook','SnAccBank','SnPeopel','SnFactor','FactorName','FactorCode'];
    protected $primaryKey = 'SerialNoBYS';
    function factor(){
        return $this->belongsTo(FactorHDS::class,'SnHDS','SerialNoHDS');
    }
}
