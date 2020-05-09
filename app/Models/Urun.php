<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\UrunDetay;

class Urun extends Model
{
    const CREATED_AT = 'olusturma_tarihi';
    const UPDATED_AT = 'guncelleme_tarihi';

    //  protected $fillable = ['slug','urun_adi','acıklama','fiyat'];
    const DELETED_AT = 'silinme_tarihi';
    protected $table = "urun";
    protected $guarded = [];

    public function kategoriler()
    {
        return $this->belongsToMany('App\Models\Kategori', 'kategori_urun');
    }

    public function detay()
    {
        return $this->hasOne('App\Models\UrunDetay')->withDefault();
    }
}
