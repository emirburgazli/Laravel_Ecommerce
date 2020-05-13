<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use App\Models\Kullanici;
use App\Models\Siparis;
use Illuminate\Support\Facades\DB;

class AnasayfaController extends Controller
{
    public function index()
    {
        $cok_satan_urunler = DB::select("
        SELECT u.urun_adi,SUM(su.adet) adet
        FROM siparis si
            INNER JOIN sepet s ON s.id = si.sepet_id
            INNER JOIN sepet_urun su ON s.id = su.sepet_id
            INNER JOIN urun u ON u.id = su.urun_id
        GROUP BY u.urun_adi
        ORDER BY SUM(su.adet) DESC
        ");

        $aylara_gore_satis = DB::select("
        SELECT
         DATE_FORMAT(si.olusturma_tarihi,'%Y-%m')ay,SUM(su.adet) adet
        FROM siparis si
            INNER JOIN sepet s ON s.id = si.sepet_id
            INNER JOIN sepet_urun su ON s.id = su.sepet_id
        GROUP BY  DATE_FORMAT(si.olusturma_tarihi,'%Y-%m')
        ORDER BY  DATE_FORMAT(si.olusturma_tarihi,'%Y-%m')
        ");
        $toplam_kazanc = Siparis::sum('siparis_tutari');
        $aktif_kullanici = Kullanici::where('aktif_mi',1)->count();
        $pasif_kullanici = Kullanici::where('aktif_mi',0)->count();
        return view('yonetim.anasayfa', compact('cok_satan_urunler', 'aylara_gore_satis','toplam_kazanc','aktif_kullanici','pasif_kullanici'));
    }
}
