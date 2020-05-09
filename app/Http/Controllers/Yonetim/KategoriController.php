<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Kullanici;
use App\Models\KullaniciDetay;
use App\Models\Urun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    public function index()
    {
        if (request()->filled('aranan') || request()->filled('ust_id')) {
            request()->flash();
            $aranan = request('aranan');
            $ust_id = request('ust_id');
            $list = Kategori::with('ust_kategori')
                ->where('kategori_adi', 'like', "%$aranan%")
                ->where('ust_id', $ust_id)
                ->orderByDesc('id')
                ->paginate(20)
                ->appends(['aranan', $aranan,'ust_id',$ust_id]);
        } else {
            request()->flush();
            $list = Kategori::with('ust_kategori')->orderByDesc('id')->paginate(20);
        }

        $anaKategoriler = Kategori::whereRaw('ust_id is null')->get();

        return view('yonetim.kategori.index', compact('list','anaKategoriler'));
    }

    public function form($id = 0)
    {
        $kategori = new Kategori;
        if ($id > 0) {
            $kategori = Kategori::find($id);
        }

        $kategoriler = Kategori::all();
        return view('yonetim.kategori.form', compact('kategori','kategoriler'));
    }

    public function kaydet($id = 0)
    {
        $guncellenecek_veriler = request()->only('kategori_adi','slug', 'ust_id');
        if (request()->filled('slug')) {
            $guncellenecek_veriler['slug'] = Str::slug(request('kategori_adi'), '-');
            request()->merge(['slug'=>$guncellenecek_veriler['slug']]);
        }
        else
        {
            $guncellenecek_veriler['slug'] = Str::slug(request('slug'), '-');
        }

        $this->validate(request(), [
            'kategori_adi' => 'required|unique:kategori',
            'slug'=>(request('original_slug') != request('slug') ? 'unique:kategori,slug' : '' )
        ]);

        if ($id > 0) {
            $kategori = Kategori::where('id', $id)->firstOrFail();
            $kategori->update($guncellenecek_veriler);
        } else {
            $kategori = Kategori::create($guncellenecek_veriler);
        }

        return redirect()
            ->route('yonetim.kategori', $kategori->id)
            ->with('mesaj', ($id > 0 ? 'Güncellendi' : 'Kaydedildi'))
            ->with('mesaj_tur', 'success');
    }


    //kategori silmeyi düzenle
    public function sil($id)
    {
        Kategori::destroy($id);
        return redirect()->route('yonetim.kategori')
            ->with('mesaj', 'kategori Silindi.')
            ->with('mesaj_tur', 'success');

    }
}
