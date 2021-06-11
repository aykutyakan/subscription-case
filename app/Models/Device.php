<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Device extends Model
{
    use HasFactory;
    const OS_IOS = 'ios';
    const OS_ANDROID = 'android';
    protected $primaryKey = "app_id";
    public $incrementing = false;

    protected $fillable = [
        "uid",
        "app_id",
        "language",
        "operating_system",
        "client_token",
    ];

    public function purchase()
    {
        return $this->hasOne(Purchase::class, "app_id", "app_id");
    }
}