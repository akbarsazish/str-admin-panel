<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;
    protected $table = 'Shop.dbo.PubBanks';
    protected $fillable = ['PubBanks','CompanyNo','CodeBsn','NameBsn'];
    protected $primaryKey = 'SerialNoBSN';
    function accBanks(){
        return $this->hasMany(AccBanks::class,'SnBank','SerialNoBSN');
    }
}
