<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccBanks extends Model
{
    use HasFactory;
    protected $table = 'Shop.dbo.AccBanks';
    protected $fillable = ['CompanyNo','AccType','AccNo','SnBank','Branch','AccDesc','IsActive','SnTaf','KartKhanType','SerialDastgah','TerminalID','Pazirandeh'];
    protected $primaryKey = 'SerialNoAcc';
    function chequeBooks(){
        return $this->hasMany(ChequeBooks::class,'SnAccBank','SerialNoAcc');
    }
    function bank(){
        return $this->belongsTo(Bank::class,'SnBank','SerialNoBSN');
    }
}
