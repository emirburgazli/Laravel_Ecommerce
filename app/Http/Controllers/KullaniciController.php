<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
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

    public function kaydol(Request $request)
    {
        $v = Validator::make($request->all(), [
            'adsoyad' => 'required|string|min:5|max:60',
            'mail'=>'required|string|email|unique:kullanici',
            'sifre'=>'required|string|confirmed|min:5|max:15'


        ]);
        if ($v->fails())
        {
            return redirect('/kullanici/kaydol')->withErrors($v->errors());
        }


        $kullanici = Kullanici::create([
            'adsoyad' => request('adsoyad'),
            'mail' => request('mail'),
            'sifre' => Hash::make(request('sifre')),
            'aktivasyon_anahtari' => Str::Random(60),
            'aktif_mi' => 0
        ]);

        auth()->login($kullanici);
        return redirect()->route('anasayfa');
    }
}
