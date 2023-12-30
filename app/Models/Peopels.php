<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peopels extends Model
{
    use HasFactory;
    protected $table = 'Shop.dbo.Peopels';
    protected $fillable = ["CompanyNo","GroupCode","PCode","Name","Description","CustomerIs","FiscalYear","peopeladdress","SaleLevel"
                            ,"SnMasir","SnNahiyeh","SnMantagheh","LatPers","LonPers"];
    protected $primaryKey = 'PSN';
    function factors(){
        return $this->hasMany(Factor::class,'CustomerSn','PSN');
    }
}
