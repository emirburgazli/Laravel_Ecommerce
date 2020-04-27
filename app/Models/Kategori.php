<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    const CREATED_AT = 'olusturma_tarihi';
    //protected $fillable = ['kategori_adi','ust_id','slug'];
    const UPDATED_AT = 'guncelleme_tarihi';
    const DELETED_AT = 'silinme_tarihi';
    protected $table = "kategori";
    protected $guarded = [];

    public function urunler(){
        return $this->belongsToMany('App\Models\Urun','kategori_urun');
    }
}
