<?php

namespace App\Http\Controllers;

use App\Models\Siparis;
use Gloudemans\Shoppingcart\Facades\Cart;
use function GuzzleHttp\Promise\all;

class OdemeController extends Controller
{

    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('kullanici.oturumac')
                ->with('mesaj', 'Ödeme İşlemi Yapabilmek İçin Oturum Açmanız Gerekmektedir.')
                ->with('mesaj_tur', 'info');
        } else if (count(Cart::content()) == 0) {
            return redirect()->route('anasayfa')
                ->with('mesaj', 'Ödeme İşlemi İçin Sepetinizde Ürün Bulunamadı.')
                ->with('mesaj_tur', 'info');
        }

        $kullanici_detay = auth()->user()->detay;

        return view('odeme', compact('kullanici_detay'));
    }

    public function odemeyap()
    {
        $siparis = request()->all();
        $siparis['sepet_id'] = session('aktif_sepet_id');
        $siparis['banka'] = "Garanti";
        $siparis['taksit_sayisi'] = 1;
        $siparis['durum'] = "Siparişiniz Alındı..";
        $siparis['siparis_tutari'] = Cart::Subtotal();

        Siparis::create($siparis);
        Cart::destroy();
        session()->forget('aktif_sepet_id');

        return redirect()->route('siparisler')
            ->with('mesaj', 'Ödeme Başarılı Bir Şekilde Gerçekleştirildi.')
            ->with('mesaj_tur', 'success');


    }
}
