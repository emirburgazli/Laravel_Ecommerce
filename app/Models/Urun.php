<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;
use App\Models\UrunDetay;

class Urun extends Model
{
    protected $table = "urun";

    protected $guarded = [];

    //  protected $fillable = ['slug','urun_adi','acıklama','fiyat'];

    const CREATED_AT = 'olusturma_tarihi';
    const UPDATED_AT = 'guncelleme_tarihi';
    const DELETED_AT = 'silinme_tarihi';


    public function kategoriler(){
        return $this->belongsToMany('App\Models\Kategori','kategori_urun');
    }
    public function detay(){
        return $this->hasOne('App\Models\UrunDetay');
    }
}
