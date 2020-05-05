<?php

namespace App\Http\Controllers;

use App\Models\Sepet;
use App\Models\SepetUrun;
use App\Models\Urun;
use Gloudemans\Shoppingcart\Facades\Cart;
use Validator;

class SepetController extends Controller
{
    public function index()
    {
        return view('sepet');
    }

    public function ekle()
    {
        $urun = Urun::find(request('id'));
        $cartItem = Cart::add($urun->id, $urun->urun_adi, 1, $urun->fiyat);
        if (auth()->check()) {
            $aktif_sepet_id = session('aktif_sepet_id');
            if (!isset($aktif_sepet_id)) {
                $aktif_sepet = Sepet::create([
                    'kullanici_id' => auth()->id()
                ]);
                $aktif_sepet_id = $aktif_sepet->id;
                session()->put('aktif_sepet_id', $aktif_sepet_id);
            }
            SepetUrun::updateOrCreate(
                ['sepet_id' => $aktif_sepet_id, 'urun_id' => $urun->id],
                ['adet' => $cartItem->qty, 'fiyati' => $urun->fiyat, 'durum' => 'Beklemede']
            );
        }
        return redirect()->route('sepet')
            ->with('mesaj', 'Ürün sepete eklendi.')
            ->with('mesaj_tur', 'success');
    }

    public function kaldir($rowid)
    {
        if (auth()->check()) {
            $aktif_sepet_id = session('aktif_sepet_id');
            $cartItem = Cart::get($rowid);
            SepetUrun::where('sepet_id', $aktif_sepet_id)->where('urun_id', $cartItem->id)->delete();
        }
        Cart::remove($rowid);
        return redirect()->route('sepet')
            ->with('mesaj', 'Ürün sepetten kaldırıldı.')
            ->with('mesaj_tur', 'success');
    }

    public function bosalt()
    {
        if (auth()->check()) {
            $aktif_sepet_id = session('aktif_sepet_id');
            SepetUrun::where('sepet_id', $aktif_sepet_id)->delete();
        }
        Cart::destroy();
        return redirect()->route('sepet')
            ->with('mesaj', 'Sepet Boşaltıldı.')
            ->with('mesaj_tur', 'success');

    }

    public function guncelle($rowid)
    {
        $validator = Validator::make(request()->all(), [
            'adet' => 'required|numeric|min:1'
        ]);
        if ($validator->fails()) {
            session()->flash('mesaj', 'Adet değeri minumum 1 olmalıdır.');
            session()->flash('mesaj_tur', 'danger');
            return response()->json(['success' => false]);
        }
        if (auth()->check()) {
            $aktif_sepet_id = session('aktif_sepet_id');
            $cartItem = Cart::get($rowid);
            SepetUrun::where('sepet_id', $aktif_sepet_id)
                ->where('urun_id', $cartItem->id)
                ->update([
                    'adet' => request('adet')]);
        }
        Cart::update($rowid, request('adet'));
        session()->flash('mesaj', 'Adet bilgisi güncellendi.');
        session()->flash('mesaj_tur', 'success');
        return response()->json(['success' => true]);

    }
}
