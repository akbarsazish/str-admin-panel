<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GetAndPayBYS extends Model
{
    use HasFactory;
    protected $table='Shop.dbo.GetAndPayBYS';
    protected $fillable =   ["CompanyNo","DocTypeBYS","Price","ChequeDate","ChequeNo","AccBankno","Owner","SnBank","Branch"
                            ,"SnChequeBook","FiscalYear","SnHDS","DocDescBYS","SnAccBank","NoPayaneh_KartKhanBys","KarMozdPriceBys","NoSayyadi","NameSabtShode","SnPeopelPay"];
    protected $primaryKey = 'SerialNoBYS';
    public $timestamps = false;
    function getAndPayHDS(){
        return $this->belongsTo(GetAndPayHDS::class,'SnHDS','SerialNoHDS');
    }
}
