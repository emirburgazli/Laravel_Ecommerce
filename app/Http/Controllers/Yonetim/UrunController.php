<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Urun;
use App\Models\UrunDetay;
use Illuminate\Support\Str;

class UrunController extends Controller
{
    public function index()
    {
        if (request()->filled('aranan')) {
            request()->flash();
            $aranan = request('aranan');
            $list = Urun::where('urun_adi', 'like', "%$aranan%")
                ->orWhere('acıklama', 'like', "%$aranan%")
                ->orderByDesc('id')
                ->paginate(20)
                ->appends('aranan', $aranan);
        } else {
            $list = Urun::orderByDesc('id')->paginate(20);
        }
        return view('yonetim.urun.index', compact('list'));
    }

    public function form($id = 0)
    {
        $urun = new Urun;
        $urun_kategorileri = [];
        if ($id > 0) {
            $urun = Urun::find($id);
            $urun_kategorileri = $urun->kategoriler()->pluck('kategori_id')->all();
        }
        $kategoriler = Kategori::all();
        return view('yonetim.urun.form', compact('urun', 'kategoriler','urun_kategorileri'));
    }

    public function kaydet($id = 0)
    {
        $guncellenecek_veriler = request()->only('urun_adi', 'slug', 'acıklama', 'fiyat');
        if (request()->filled('slug')) {
            $guncellenecek_veriler['slug'] = Str::slug(request('slug'), '-');
            request()->merge(['slug' => $guncellenecek_veriler['slug']]);
        } else {
            $guncellenecek_veriler['slug'] = Str::slug(request('urun_adi'), '-');
            request()->merge(['slug' => $guncellenecek_veriler['slug']]);
        }

        if (request()->filled('acıklama')) {
            $guncellenecek_veriler['acıklama'] = Str::slug(request('acıklama'), '-');
        } else {
            $guncellenecek_veriler['acıklama'] = '';
        }

        $this->validate(request(), [
            'urun_adi' => 'required',
            'fiyat' => 'required',
            'slug' => (request('original_slug') != request('slug') ? 'unique:urun,slug' : '')
        ]);

        $urun_detay = request()->only('goster_slider', 'goster_gunun_firsati', 'goster_one_cikanlar', 'goster_cok_satanlar', 'goster_indirimli');

        $kategoriler = request('kategoriler');

        if ($id > 0) {
            $urun = Urun::where('id', $id)->firstOrFail();
            $urun->update($guncellenecek_veriler);
            $urun->detay()->update($urun_detay);
            $urun->kategoriler()->sync($kategoriler);
        } else {
            $urun = Urun::create($guncellenecek_veriler);
            $urun->detay()->create($urun_detay);
            $urun->kategoriler()->attach($kategoriler);
        }


        if (request()->hasFile('urun_resmi'))
        {
            $this->validate(request(), [
                'urun_resmi' => 'image|mimes:jpg,png,jpeg|max:2048'

            ]);

            $urun_resmi =request()->file('urun_resmi');
            $urun_resmi =request()->urun_resmi;
            //$urun_resmi->getClientOrginalName();
            //$urun_resmi->extension();
            //$urun_resmi->hashName();
            $dosyaadi = $urun->id ."-" .time() . "." . $urun_resmi->extension();
            //$dosyaadi = $urun_resmi->getClientOriginalName();
            //$dosyaadi = $urun_resmi->hashName();

            if ($urun_resmi->isValid())
            {
                $urun_resmi->move('uploads/urunler',$dosyaadi);

                UrunDetay::updateOrCreate(
                    ['urun_id'=>$urun->id],
                    ['urun_resmi'=>$dosyaadi]

                );
            }
        }

        return redirect()
            ->route('yonetim.urun', $urun->id)
            ->with('mesaj', ($id > 0 ? 'Güncellendi' : 'Kaydedildi'))
            ->with('mesaj_tur', 'success');
    }

    public function sil($id)
    {
        $urun = Urun::find($id);
        $urun->kategoriler()->detech();
        //$urun->detay()->delete();
        $urun->delete();

        return redirect()->route('yonetim.urun')
            ->with('mesaj', 'Kullanıcı Silindi.')
            ->with('mesaj_tur', 'success');
    }
}
