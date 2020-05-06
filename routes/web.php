<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'yonetim', 'namespace' => 'Yonetim'], function () {
    Route::redirect('/', 'yonetim/oturumac');
    Route::match(['get', 'post'], '/oturumac', 'KullaniciController@oturumac')->name('yonetim.oturumac');
    Route::get('/oturumukapat', 'KullaniciController@oturumukapat')->name('yonetim.oturumukapat');

    Route::group(['middleware' => 'yonetim'], function () {
        Route::get('/anasayfa', 'AnasayfaController@index')->name('yonetim.anasayfa');
    });

    Route::group(['prefix' => 'kullanici'], function () {
        Route::match(['get', 'post'], '/', 'KullaniciController@index')->name('yonetim.kullanici');
        Route::get('/yeni', 'KullaniciController@form')->name('yonetim.kullanici.yeni');
        Route::post('/duzenle/{id}', 'KullaniciController@form')->name('yonetim.kullanici.duzenle');
        Route::post('/kaydet/{id?}', 'KullaniciController@kaydet')->name('yonetim.kullanici.kaydet');
        Route::get('/sil/{id}', 'KullaniciController@sil')->name('yonetim.kullanici.sil');
    });

});
Route::get('/', 'AnasayfaController@index')->name('anasayfa');
Route::get('/kategori/{slug}', 'KategoriController@index')->name('kategori');
Route::get('/urun/{slug}', 'UrunController@index')->name('urun');
Route::post('/ara', 'UrunController@ara')->name('urun_ara');
Route::get('/ara', 'UrunController@ara')->name('urun_ara');

Route::group(['prefix' => 'sepet'], function () {
    Route::get('/', 'SepetController@index')->name('sepet');
    Route::post('/ekle', 'SepetController@ekle')->name('sepet.ekle');
    Route::delete('/kaldir/{rowid}', 'SepetController@kaldir')->name('sepet.kaldir');
    Route::delete('/bosalt', 'SepetController@bosalt')->name('sepet.bosalt');
    Route::patch('/guncelle/{rowid}', 'SepetController@guncelle')->name('sepet.guncelle');
});
Route::get('/odeme', 'OdemeController@index')->name('odeme');
Route::post('/odeme', 'OdemeController@odemeyap')->name('odemeyap');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/siparisler', 'SiparisController@index')->name('siparisler');
    Route::get('/siparis/{id}', 'SiparisController@detay')->name('siparis');
});
Route::group(['prefix' => 'kullanici'], function () {
    Route::get('/oturumac', 'KullaniciController@giris_form')->name('kullanici.oturumac');
    Route::post('/oturumac', 'KullaniciController@giris');
    Route::get('/kaydol', 'KullaniciController@kaydol_form')->name('kullanici.kaydol');
    Route::post('/kaydol', 'KullaniciController@kaydol');
    Route::get('/aktiflestir/{anahtar}', 'KullaniciController@aktiflestir')->name('aktiflestir');
    Route::get('/oturumukapat', 'KullaniciController@oturumukapat')->name('kullanici.oturumukapat');
});
Route::get('test/mail', function () {
    $kullanici = App\Models\Kullanici::find(11);
    return new App\Mail\KullaniciKayitMail($kullanici);
});
