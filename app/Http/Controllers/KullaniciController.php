<?php

namespace App\Http\Controllers;

use App\Models\Kullanici;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class KullaniciController extends Controller
{
    public function giris_form()
    {
        return view('kullanici.oturumac');
    }

    public function kaydol_form()
    {
        return view('kullanici.kaydol');
    }

    public function kaydol()
    {
        $this->validate(request(),[
            'adsoyad'                => 'required | min:5 | max: 60',
            'mail'                   => 'required | mail | unique:kullanici',
            'sifre'                  => 'required | confirmed | min:5 | max: 15'

        ]);

        $kullanici = Kullanici::create([
            'adsoyad'                => request('adsoyad'),
            'mail'                   => request('mail'),
            'sifre'                  => Hash::make(request('sifre')),
            'aktivasyon_anahtari'    => Str::Random(60),
            'aktif_mi'               => 0
        ]);

        auth()->login($kullanici);
        return redirect()->route('anasayfa');
    }
}
