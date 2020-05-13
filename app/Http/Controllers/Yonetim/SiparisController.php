<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use App\Models\Siparis;
use App\Models\Urun;

class SiparisController extends Controller
{
    public function index()
    {
        if (request()->filled('aranan')) {
            request()->flash();
            $aranan = request('aranan');
            $list = Siparis::with('sepet.kullanici')
                ->where('adsoyad', 'like', "%$aranan%")
                ->orWhere('id', $aranan)
                ->orderByDesc('id')
                ->paginate(20)
                ->appends('aranan', $aranan);
        } else {
            $list = Siparis::with('sepet.kullanici')->orderByDesc('id')->paginate(20);
        }
        return view('yonetim.siparis.index', compact('list'));
    }

    public function form($id = 0)
    {
        if ($id > 0) {
            $siparis = Siparis::with('sepet.sepet_urunler.urun')->find($id);
        }
        return view('yonetim.siparis.form', compact('siparis'));
    }

    public function kaydet($id = 0)
    {
        $this->validate(request(), [
            'adsoyad' => 'required',
            'adres' => 'required',
            'telefon' => 'required',
            'durum' => 'required',
        ]);

        $guncellenecek_veriler = request()->only('adsoyad', 'telefon', 'ceptelefon', 'adres', 'durum');

        if ($id > 0) {
            $siparis = Siparis::where('id', $id)->firstOrFail();
            $siparis->update($guncellenecek_veriler);
        }

        return redirect()
            ->route('yonetim.siparis', $siparis->id)
            ->with('mesaj', 'Güncellendi')
            ->with('mesaj_tur', 'success');
    }

    public function sil($id)
    {
        Siparis::destroy($id);

        return redirect()->route('yonetim.siparis')
            ->with('mesaj', 'Kullanıcı Silindi.')
            ->with('mesaj_tur', 'success');
    }
}
