<?php

namespace App\Http\Controllers;

use App\Mail\KullaniciKayitMail;
use App\Models\Kullanici;
use App\Models\KullaniciDetay;
use App\Models\Sepet;
use App\Models\SepetUrun;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Validator;

class KullaniciController extends Controller
{
    public function giris_form()
    {
        return view('kullanici.oturumac');
    }

    public function giris()
    {
        $this->validate(request(), [
            'mail' => 'required|email',
            'sifre' => 'required'
        ]);
        if (auth()
            ->attempt(['mail' => request('mail'), 'password' => request('sifre')], request()
                ->has('benihatirla'))) {
            request()->session()->regenerate();

            $aktif_sepet_id = Sepet::aktif_sepet_id();
            if (!is_null($aktif_sepet_id)) {
                $aktif_sepet = Sepet::create([
                    'kullanici_id' => auth()->id()]);
                $aktif_sepet_id=$aktif_sepet->id;
            }
            session()->put('aktif_sepet_id', $aktif_sepet_id);
            if (Cart::count() > 0) {
                foreach (Cart::content() as $cartItem) {
                    SepetUrun::updateOrCreate(
                        ['sepet_id' => $aktif_sepet_id, 'urun_id' => $cartItem->id],
                        ['adet' => $cartItem->qty, 'fiyati' => $cartItem->price, 'durum' => 'Beklemede']
                    );
                }
            }

            Cart::destroy();
            $sepetUrunler = SepetUrun::with('urun')->where('sepet_id', $aktif_sepet_id)->get();
            foreach ($sepetUrunler as $sepetUrun) {
                Cart::add($sepetUrun->urun->id, $sepetUrun->urun->urun_adi, $sepetUrun->adet, $sepetUrun->fiyati);
            }

            return redirect()->intended('/');
        } else {
            $errors = ['mail' => 'Hatalı Giriş'];
            return back()->withErrors($errors);
        }
    }

    public function kaydol_form()
    {
        return view('kullanici.kaydol');
    }

    public function aktiflestir($anahtar)
    {

        $kullanici = Kullanici::where('aktivasyon_anahtari', $anahtar)->first();
        if (!is_null($kullanici)) {
            $kullanici->aktivasyon_anahtari = null;
            $kullanici->aktif_mi = 1;
            $kullanici->save();
            return redirect('/')
                ->with('mesaj', 'Kullanıcı kaydınız Aktifleştirildi.')
                ->with('mesaj_tur', 'success');
            auth()->login($kullanici);
        } else {
            return redirect('/')
                ->with('mesaj', 'Kullanıcı kaydınız Aktifleştirilemedi.')
                ->with('mesaj_tur', 'warning');
        }
    }

    public function kaydol(Request $request)
    {
        $v = Validator::make($request->all(), [
            'adsoyad' => 'required|string|min:5|max:60',
            'mail' => 'required|string|email|unique:kullanici',
            'sifre' => 'required|string|confirmed|min:5|max:15'
        ]);
        if ($v->fails()) {
            return redirect('/kullanici/kaydol')->withErrors($v->errors());
        }
        $kullanici = Kullanici::create([
            'adsoyad' => request('adsoyad'),
            'mail' => request('mail'),
            'sifre' => Hash::make(request('sifre')),
            'aktivasyon_anahtari' => Str::Random(60),
            'aktif_mi' => 0
        ]);

        $kullanici->detay()->save(new KullaniciDetay());

        Mail::to(request('mail'))->send(new KullaniciKayitMail($kullanici));

        auth()->guest($kullanici);

        return redirect('/')
            ->with('mesaj', 'Mail Adresinizden üyeliğinizi aktifleştirin.')
            ->with('mesaj_tur', 'warning');
    }

    public function oturumukapat()
    {
        auth()->logout();
        request()->session()->flush();
        request()->session()->regenerate();
        return redirect()->route('anasayfa');
    }
}
