<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use App\Models\Kullanici;
use App\Models\KullaniciDetay;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\validate;


class KullaniciController extends Controller
{
    public function oturumac()
    {
        if (request()->isMethod('POST')) {

            $this->validate(request(), [
                'mail' => 'required|email',
                'sifre' => 'required'
            ]);

            $credentials = [
                'mail' => request('mail'),
                'password' => request('sifre'),
                'yonetici_mi' => 1,
                'aktif_mi' => 1
            ];

            if (Auth::guard('yonetim')->attempt($credentials, request()->has('benihatirla'))) {
                return redirect()->route('yonetim.anasayfa');
            } else {
                return back()->withInput()->withErrors(['mail' => 'Giriş Hatalı']);
            }
        }
        return view('yonetim.oturumac');
    }

    public function oturumukapat()
    {
        Auth::guard('yonetim')->logout();
        request()->session()->flush();
        request()->session()->regenerate();
        return redirect()->route('yonetim.oturumac');
    }

    public function index()
    {
        if (request()->filled('aranan')) {
            request()->flash();
            $aranan = request('aranan');
            $list = Kullanici::where('adsoyad', 'like', "%$aranan%")
                ->orWhere('mail', 'like', "%$aranan%")
                ->orderByDesc('olusturma_tarihi')
                ->paginate(20)
                ->appends('aranan', $aranan);
        } else {
            $list = Kullanici::orderByDesc('olusturma_tarihi')->paginate(20);
        }
        return view('yonetim.kullanici.index', compact('list'));
    }

    public function form($id = 0)
    {
        $kullanici = new Kullanici;
        if ($id > 0) {
            $kullanici = Kullanici::find($id);
        }
        return view('yonetim.kullanici.form', compact('kullanici'));
    }

    public function kaydet($id = 0)
    {
        $guncellenecek_veriler = request()->only('adsoyad', 'mail');
        if (request()->filled('slug')) {
            $guncellenecek_veriler['slug'] = Str::slug(request('kategori_adi'), '-');
            request()->merge(['slug'=>$guncellenecek_veriler['slug']]);
        }

        $this->validate(request(), [
            'mail' => (request('original_mail') != request('mail') ? 'unique:kullanici,mail' : '' ),
            'adsoyad' => 'required',

        ]);

        if (request()->filled('sifre')) {
            $guncellenecek_veriler['sifre'] = Hash::make(request('sifre'));
        }
        $guncellenecek_veriler['aktif_mi'] = request()->has('aktif_mi') && request('aktif_mi') == 1 ? 1 : 0;
        $guncellenecek_veriler['yonetici_mi'] = request()->has('yonetici_mi') && request('yonetici_mi') == 1 ? 1 : 0;

        if ($id > 0) {
            $kullanici = Kullanici::where('id', $id)->firstOrFail();
            $kullanici->update($guncellenecek_veriler);
        } else {
            $kullanici = Kullanici::create($guncellenecek_veriler);
        }

        KullaniciDetay::updateOrCreate(
            ['kullanici_id' => $kullanici->id],
            [
                'adres' => request('adres'),
                'telefon' => request('telefon'),
                'ceptelefonu' => request('ceptelefonu')
            ]
        );

        return redirect()
            ->route('yonetim.kullanici', $kullanici->id)
            ->with('mesaj', ($id > 0 ? 'Güncellendi' : 'Kaydedildi'))
            ->with('mesaj_tur', 'success');
    }

    public function sil($id)
    {
        Kullanici::destroy($id);

        return redirect()->route('yonetim.kullanici')
            ->with('mesaj', 'Kullanıcı Silindi.')
            ->with('mesaj_tur', 'success');
    }
}
