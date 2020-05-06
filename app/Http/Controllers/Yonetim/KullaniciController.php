<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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

            if (Auth::guard('yonetim')
                ->attempt(['mail' => request('mail'), 'password' => request('sifre'), 'yonetici_mi' => 1], request()
                    ->has('benihatirla'))) {
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
}
