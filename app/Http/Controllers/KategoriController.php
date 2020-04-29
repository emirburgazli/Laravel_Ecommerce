<?php

namespace App\Http\Controllers;

use App\Models\Kategori;


class KategoriController extends Controller
{
    public function index($slug)
    {
        $kategori = Kategori::where('slug', $slug)->firstOrFail();
        $alt_kategoriler = Kategori::where('ust_id', $kategori->id)->get();

        $order = request('order');
        if ($order == 'coksatanlar') {
            $urunler = $kategori->urunler()
                ->distinct()
                ->join('urun_detay', 'urun_detay.urun_id', 'urun.id')
                ->orderBy('urun_detay.goster_cok_satanlar', 'desc')
                ->paginate(4);
        } elseif ($order == 'yeni') {
            $urunler = $kategori->urunler()
                ->distinct()
                ->orderByDesc('guncelleme_tarihi')
                ->paginate(4);
        } else {
            $urunler = $kategori->urunler()
                ->distinct()
                ->paginate(4);
        }
        return view('kategori', compact('kategori', 'alt_kategoriler', 'urunler'));
    }
}
