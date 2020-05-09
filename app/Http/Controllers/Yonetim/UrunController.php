<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
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
        if ($id > 0) {
            $urun = Urun::find($id);
        }
        return view('yonetim.urun.form', compact('urun'));
    }

    public function kaydet($id = 0)
    {

        $guncellenecek_veriler = request()->only('urun_adi', 'acıklama', 'slug','fiyat');
        if (request()->filled('slug')) {
            $guncellenecek_veriler['slug'] = Str::slug(request('slug'), '-');
            request()->merge(['slug'=>$guncellenecek_veriler['slug']]);
        }
        else
        {
            $guncellenecek_veriler['slug'] = Str::slug(request('urun_adi'), '-');
        }

        $this->validate(request(), [
            'urun_adi' => 'required',
            'fiyat' => 'required',
            'slug' => (request('original_slug') != request('slug') ? 'unique:urun,slug' : '' )
        ]);

        if (request()->filled('acıklama')) {
            $guncellenecek_veriler['acıklama'] = Str::slug(request('acıklama'), '-');
        } else {
            $guncellenecek_veriler['acıklama'] = '';
        }
        $urun_detay = request()->only('goster_slider', 'goster_gunun_firsati', 'goster_one_cikanlar', 'goster_cok_satanlar', 'goster_indirimli');

        if ($id > 0) {
            $urun = Urun::where('id', $id)->firstOrFail();
            $urun->update($guncellenecek_veriler);
            $urun->detay()->update($urun_detay);
        } else {
            $urun = Urun::create($guncellenecek_veriler);
            $urun->detay()->create($urun_detay);
        }

        return redirect()
            ->route('yonetim.urun', $urun->id)
            ->with('mesaj', ($id > 0 ? 'Güncellendi' : 'Kaydedildi'))
            ->with('mesaj_tur', 'success');
    }

    public function sil($id)
    {
        Urun::destroy($id);

        return redirect()->route('yonetim.urun')
            ->with('mesaj', 'Kullanıcı Silindi.')
            ->with('mesaj_tur', 'success');
    }
}
