<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'AnasayfaController@index')->name('anasayfa');
Route::get('/kategori/{slug}', 'KategoriController@index')->name('kategori');
Route::get('/urun/{slug}', 'UrunController@index')->name('urun');
Route::post('/ara', 'UrunController@ara')->name('urun_ara');
Route::get('/ara', 'UrunController@ara')->name('urun_ara');
Route::get('/sepet', 'SepetController@index')->name('sepet');
Route::get('/odeme', 'OdemeController@index')->name('odeme');
Route::get('/siparisler', 'SiparisController@index')->name('siparisler');
Route::get('/siparis/{id}', 'SiparisController@detay')->name('siparis');

Route::group(['prefix' => 'kullanici'], function () {
    Route::get('/oturumac', 'KullaniciController@giris_form')->name('kullanici.oturumac');
    Route::post('/oturumac', 'KullaniciController@giris');
    Route::get('/kaydol', 'KullaniciController@kaydol_form')->name('kullanici.kaydol');
    Route::post('/kaydol', 'KullaniciController@kaydol');
    Route::get('/aktiflestir/{anahtar}', 'KullaniciController@aktiflestir')->name('aktiflestir');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('test/mail',function(){
    $kullanici = App\Models\Kullanici::find(11);
 return new App\Mail\KullaniciKayitMail($kullanici);
});
