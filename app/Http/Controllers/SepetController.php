<?php

namespace App\Http\Controllers;

use App\Models\Urun;
use Gloudemans\Shoppingcart\Facades\Cart;

class SepetController extends Controller
{
    public function index()
    {
        return view('sepet');
    }

    public function ekle()
    {
        $urun = Urun::find(request('id'));
        Cart::add($urun->id, $urun->urun_adi, 1, $urun->fiyat);
       return redirect()->route('sepet')
           ->with('mesaj','Ürün sepete eklendi.')
           ->with('mesaj_tur','success');
    }
}
