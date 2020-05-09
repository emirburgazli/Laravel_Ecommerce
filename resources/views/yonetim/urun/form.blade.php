@extends('yonetim.layouts.master')
@section('title','Ürün Yönetimi')
@section('content')
    <h1 class="page-header">Ürün Yönetimi</h1>
    <form method="post" action="{{ route('yonetim.urun.kaydet' , @$urun->id) }}">
        {{csrf_field()}}
        <div class="pull-right">
            <button type="submit" class="btn btn-primary">
                {{$urun->id > 0 ? 'Güncelle' : 'Kaydet'}}
            </button>
        </div>
        <h4 class="sub-header">
            Ürün {{$urun->id > 0 ?"Düzenle" : "Ekle"}}
        </h4>
        @include('layouts.partials.errors')
        @include('layouts.partials.alert')

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="urun_adi">Ürün Adı</label>
                    <input type="text" class="form-control" name="urun_adi" id="urun_adi"
                           placeholder="Ürün Adı" value={{old('urun_adi',$urun->urun_adi)}}>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" class="form-control" name="slug" id="slug" placeholder="slug"
                           value={{old('slug',$urun->slug)}} >
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="acıklama">Açıklama</label>
                    <textarea class="form-control" name="acıklama" id="acıklama"
                              placeholder="Açıklama" value={{old('acıklama',$urun->acıklama)}}></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="fiyat">Fiyatı</label>
                    <input type="text" class="form-control" name="fiyat" id="fiyat" placeholder="fiyat"
                           value={{old('fiyat',$urun->fiyat)}} >
                </div>
            </div>
        </div>
        <div class="checkbox">
            <label>
                <input type="hidden" name="goster_slider" value="0">
                <input type="checkbox" name="goster_slider" value="1" {{ old('goster_slider',$urun->detay->aktif_mi) ? 'checked' : ''}} > Slider'da Göster
            </label>
            <label>
                <input type="hidden" name="goster_gunun_firsati" value="0">
                <input type="checkbox" name="goster_gunun_firsati" value="1" {{ old('goster_gunun_firsati',$urun->detay->goster_gunun_firsati) ? 'checked' : ''}} > Günün Fırsatların'da Göster
            </label>
            <label>
                <input type="hidden" name="goster_one_cikanlar" value="0">
                <input type="checkbox" name="goster_one_cikanlar" value="1" {{ old('goster_one_cikanlar',$urun->detay->goster_one_cikanlar) ? 'checked' : ''}} > Öne Çıkanlar'da Göster
            </label>
            <label>
                <input type="hidden" name="goster_cok_satanlar" value="0">
                <input type="checkbox" name="goster_cok_satanlar" value="1" {{ old('goster_cok_satanlar',$urun->detay->goster_cok_satanlar) ? 'checked' : ''}} > Çok Satanlar'da Göster
            </label>
            <label>
                <input type="hidden" name="goster_indirimli" value="0">
                <input type="checkbox" name="goster_indirimli" value="1" {{ old('goster_indirimli',$urun->detay->goster_indirimli) ? 'checked' : ''}} > İndirimliler'de Göster
            </label>
        </div>
    </form>
@endsection

