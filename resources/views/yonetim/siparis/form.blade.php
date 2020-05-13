@extends('yonetim.layouts.master')
@section('title','Sipariş Yönetimi')
@section('content')
    <h1 class="page-header">Sipariş Yönetimi</h1>
    <form method="post" action="{{ route('yonetim.siparis.kaydet' , $siparis->id) }}">
        {{csrf_field()}}
        <div class="pull-right">
            <button type="submit" class="btn btn-primary">
                {{$siparis->id > 0 ? 'Güncelle' : 'Kaydet'}}
            </button>
        </div>
        <h4 class="sub-header">
            Sipariş {{$siparis->id > 0 ?"Düzenle" : "Ekle"}}
        </h4>
        @include('layouts.partials.errors')
        @include('layouts.partials.alert')

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="adsoyad">Ad Soyad</label>
                    <input type="text" class="form-control" name="adsoyad" id="adsoyad" placeholder="Ad Soyad" value="{{old('adsoyad',$siparis->adsoyad)}}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="telefon">Telefon</label>
                    <input type="text" class="form-control" name="telefon" id="telefon" placeholder="Telefon"
                           value="{{old('telefon',$siparis->telefon)}}" >
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="ceptelefonu">Cep Telefonu</label>
                    <input type="text" class="form-control" name="ceptelefonu" id="ceptelefonu" placeholder="Cep Telefonu"
                           value="{{old('ceptelefonu',$siparis->ceptelefonu)}}" >
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="adres">Adres</label>
                    <input type="text" class="form-control" name="adres" id="adres" placeholder="Adres"
                           value="{{old('adres',$siparis->adres)}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="durum">Durum</label>
                    <select name="durum" class="form-control" id="durum">
                        <option {{old('durum',$siparis->durum) == 'Siparişiniz Alındı..' ? 'selected' : ''}}>Siparişiniz Alındı..</option>
                        <option {{old('durum',$siparis->durum) == 'Ödemeniz Onaylandı..' ? 'selected' : ''}}>Ödemeniz Onaylandı..</option>
                        <option {{old('durum',$siparis->durum) == 'Kargoya Verildi..' ? 'selected' : ''}}>Kargoya Verildi..</option>
                        <option {{old('durum',$siparis->durum) == 'Siparişiniz Tamamlandı..' ? 'selected' : ''}}>Siparişiniz Tamamlandı..</option>
                    </select>
                </div>
            </div>
        </div>
    </form>

    <h3>Sipariş (SP-{{$siparis->id}}</h3>
    <table class="table table-bordererd table-hover">
        <tr>
            <th colspan="2">Ürün</th>
            <th>Tutar</th>
            <th>Adet</th>
            <th>Ara Toplam</th>
            <th>Durum</th>
        </tr>
        @foreach($siparis->sepet->sepet_urunler as $sepet_urun)
            <tr>
                <td style="width: 120px">
                    <a href="{{route('urun',$sepet_urun->urun->slug)}}">
                        <img src="{{$sepet_urun->urun->detay->urun_resmi !=null  ? '/uploads/urunler/' . $sepet_urun->urun->detay->urun_resmi: 'https://via.placeholder.com/120x100?text=UrunResmi' }}" class="img-responsive" style="width: 120px;">
                    </a>
                </td>
                <td>
                    <a href="{{route('urun',$sepet_urun->urun->slug)}}">
                        {{$sepet_urun->urun->urun_adi}}
                    </a>
                </td>
                <td>{{$sepet_urun->fiyati}}₺</td>
                <td>{{$sepet_urun->adet}}</td>
                <td>{{ $sepet_urun->fiyati * $sepet_urun->adet }}₺</td>
                <td>{{$sepet_urun->durum}}</td>
            </tr>
        @endforeach
        <tr>
            <th colspan="4">Toplam Tutar</th>
            <th colspan="2">{{$siparis->siparis_tutari}}₺</th>
        </tr>
        <tr>
            <th colspan="4">Toplam Tutar (KDV Dahil)</th>
            <th colspan="2">{{$siparis->siparis_tutari * ((100+config('cart.tax'))/100) }}₺</th>
        </tr>
        <tr>
            <th colspan="4">Sipariş Durumu</th>
            <th colspan="2">{{$siparis->durum}}</th>
        </tr>
    </table>
@endsection
