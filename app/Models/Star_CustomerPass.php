<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Star_CustomerPass as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class Star_CustomerPass extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'NewStarfood.dbo.star_CustomerPass';

    protected $fillable = [
        'customerId',
        'customerPss',
        'userName',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
