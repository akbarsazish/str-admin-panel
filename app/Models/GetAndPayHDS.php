<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GetAndPayHDS extends Model
{
    use HasFactory;
    protected $table='Shop.dbo.GetAndPayHDS';
    protected $fillable = ["CompanyNo","GetOrPayHDS","DocNoHDS","DocDate","DocDescHDS","PeopelHDS"
                            ,"FiscalYear","SnFactor","InForHDS","NetPriceHDS","DocTypeHDS","SnCashMaster"];
    protected $primaryKey = 'SerialNoHDS';
    public $timestamps = false;
    function getAndPayBYS(){
        return $this->hasMany(GetAndPayBYS::class,'SnHDS','SerialNoHDS');
    }
}
