@extends('yonetim.layouts.master')
@section('title','Sipariş Yönetimi')
@section('content')
    <h1 class="page-header">Sipariş Yönetimi</h1>

    <div class="well">
        <form method="post" action="{{route('yonetim.siparis')}}" class="form-inline">
            {{csrf_field()}}
            <div class="form-group">
                <label for="aranan">Ara</label>
                <input type="text" class="form-control form-control-sm" name="aranan" id="aranan"
                       placeholder="Sipariş Ara.." value="{{old('aranan')}}">
            </div>
            <button type="submit" class="btn btn-primary">Ara</button>
            <a href="{{route('yonetim.siparis')}}" class="btn btn-primary">Temizle</a>
        </form>
    </div>
    <h4 class="sub-header"> Ürün Listesi </h4>
    @include('layouts.partials.alert')
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>Sipariş Kodu</th>
                <th>Kullanıcı</th>
                <th>Tutar</th>
                <th>Durum</th>
                <th>Sipariş Tarihi</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @if(count($list)==0)
                <tr>
                    <td colspan="7" class="text-center">Kayıt Bulunamadı..</td>
                </tr>
            @endif
            @foreach($list as $siparis)
                <tr>
                    <th>SP-{{$siparis->id}}</th>
                    <th>{{ $siparis->sepet->kullanici->adsoyad }}</th>
                    <td>{{$siparis->siparis_tutari * ((100 + config('cart.tax')) / 100)}} ₺</td>
                    <td>{{$siparis->durum}}</td>
                    <td>{{$siparis->olusturma_tarihi}}</td>
                    <td style="width: 100px">
                        <a href="{{route('yonetim.siparis.duzenle',$siparis->id)}} " class="btn btn-xs btn-success"
                           data-toggle="tooltip" data-placement="top"
                           title="Düzenle">
                            <span class="fa fa-pencil"></span>
                        </a>
                        <a href="{{route('yonetim.siparis.sil', $siparis->id)}}" class="btn btn-xs btn-danger"
                           data-toggle="tooltip" data-placement="top"
                           title="Sil" onclick="return confirm('Emin Misiniz?')">
                            <span class="fa fa-trash"></span>
                        </a>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
        {{$list->appends('aranan',old('aranan'))->links()}}
    </div>
@endsection
