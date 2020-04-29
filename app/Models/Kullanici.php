<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Kullanici extends Authenticatable
{
    use SoftDeletes;

    const CREATED_AT = 'olusturma_tarihi';
    const UPDATED_AT = 'guncelleme_tarihi';
    const DELETED_AT = 'silinme_tarihi';
    protected $table = "kullanici";
    protected $fillable = ['adsoyad', 'mail', 'sifre', 'aktivasyon_anahtari', 'aktif_mi'];
    protected $hidden = ['sifre', 'aktivasyon_anahtari',];
}
