<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChequeBooks extends Model
{
    use HasFactory;
    protected $table = 'Shop.dbo.ChequeBooks';
    protected $fillable = ['CompanyNo','SnAccBank','ChequeBookName','FirstSerialNo','EndSerialNo'];
    protected $primaryKey = 'SnChequeBook';
    function accBanks(){
        return $this->belongsTo(AccBanks::class,'SnAccBank','SerialNoAcc');
    }

}
