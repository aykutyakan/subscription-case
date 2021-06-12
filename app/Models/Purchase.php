<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = [
        "device_app_id",
        "reciept",
        "expire_date",
        "is_active",
    ];

    public function ownerDevice()
    {
        return $this->belongsTo(Device::class, "device_app_id", "id");
    }

    public function scopeActive($query) 
    {
        return $query->where('is_active', 1);
    }
}
