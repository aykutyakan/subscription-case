<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;
    protected $fillable = [
        "uid",
        "app_id",
        "language",
        "operating_system",
        "client_token",
    ];
}

/* 
    user -> register olacak
    user -> tekrar tekrar register olamayacak
    user -> kontrol edecek aboneliğini
    system-> callback fırlatacak(kayit- yenilenme - iptal olmada),
    worker -> kayıtları kontrol edecek command yardımıyla
    worker -> tarihi geçmiş aktif kayıtları yeniden faturandıracak edecek
    worker -> 
    worker 
        -> expire date check edilecek
        -> süresi geçmiş ler tekrar aktive edilecek
            -> son 2 rakam 6 bölünüyorsa pasif edilecek
            -> tekrar expire edilecek

    callback
        -> herhangi bir cihazın durumunda eğişiklik varsa request atılacak
        -> started, renewed, cancaled,

*/