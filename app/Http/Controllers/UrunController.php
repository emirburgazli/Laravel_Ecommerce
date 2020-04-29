<?php

namespace App\Http\Controllers;

use App\Models\Urun;


class UrunController extends Controller
{
    public function index($slug)
    {
        $urun = Urun::where('slug', $slug)->firstOrFail();
        $kategoriler = $urun->kategoriler()->distinct()->get();
        return view('urun', compact('urun', 'kategoriler'));
    }

    public function ara()
    {
        $aranan = request()->input('aranan');
        $urunler = Urun::where('urun_adi', 'like', "%$aranan%")
            ->orWhere('acıklama', 'like', "%$aranan%")
            ->paginate(4);

        request()->flash();
        return view('arama', compact('urunler'));

    }
}
