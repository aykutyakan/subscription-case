<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = [
        "app_id",
        "reciept",
        "expire_date",
        "username",
        "password",
        "is_active",
    ];

    public function OwnerDevice()
    {
        return $this->belongsTo(Device::class, "app_id", "app_id");
    }
}
