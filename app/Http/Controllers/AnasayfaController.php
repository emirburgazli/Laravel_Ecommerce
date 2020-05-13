<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Urun;
use App\Models\UrunDetay;

class AnasayfaController extends Controller
{
    public function index()
    {
        $kategoriler = Kategori::whereRaw('ust_id is null')->take(8)->get();

        $urunler_slider = Urun::select('urun.*')
            ->join('urun_detay', 'urun_detay.urun_id', 'urun.id')
            ->where('urun_detay.goster_slider', 1)
            ->orderBy('guncelleme_tarihi', 'desc')
            ->take(get_ayar('anasayfa_slider_urun_adet'))->get();

        $urun_gunun_firsati = Urun::select('urun.*')
            ->join('urun_detay', 'urun_detay.urun_id', 'urun.id')
            ->where('urun_detay.goster_gunun_firsati', 1)
            ->orderBy('guncelleme_tarihi', 'desc')
            ->first();

        $goster_one_cikanlar = Urun::select('urun.*')
            ->join('urun_detay', 'urun_detay.urun_id', 'urun.id')
            ->where('urun_detay.goster_one_cikanlar', 1)
            ->orderBy('guncelleme_tarihi', 'desc')
            ->take(get_ayar('anasayfa_one_cikan_urunler'))->get();

        $goster_cok_satanlar = Urun::select('urun.*')
            ->join('urun_detay', 'urun_detay.urun_id', 'urun.id')
            ->where('urun_detay.goster_cok_satanlar', 1)
            ->orderBy('guncelleme_tarihi', 'desc')
            ->take(get_ayar('anasayfa_cok_satan_urunler'))->get();

        $goster_indirimli =  Urun::select('urun.*')
            ->join('urun_detay', 'urun_detay.urun_id', 'urun.id')
            ->where('urun_detay.goster_indirimli', 1)
            ->orderBy('guncelleme_tarihi', 'desc')
            ->take(get_ayar('anasayfa_indirimli_urunler'))->get();

        //$urunler_slider = UrunDetay::with('urun')->where('goster_slider', 1)->take(5)->get();
        //$goster_one_cıkanlar = UrunDetay::with('urun')->where('goster_one_cıkanlar', 1)->take(4)->get();
        //$goster_cok_satanlar = UrunDetay::with('urun')->where('goster_cok_satanlar', 1)->take(4)->get();
        //$goster_indirimli = UrunDetay::with('urun')->where('goster_indirimli', 1)->take(4)->get();
        return view('anasayfa', compact('kategoriler', 'urunler_slider', 'urun_gunun_firsati','goster_indirimli','goster_cok_satanlar','goster_one_cikanlar'));
    }
}
