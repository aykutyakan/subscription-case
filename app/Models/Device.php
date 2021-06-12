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

    protected $fillable = [
        "device_id",
        "app_id",
        "language",
        "operating_system",
        "os_username",
        "os_password",
        "client_token",
    ];

    public function purchase()
    {
        return $this->hasOne(Purchase::class, "device_app_id");
    }
}