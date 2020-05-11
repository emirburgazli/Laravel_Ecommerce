@extends('yonetim.layouts.master')
@section('title','Ürün Yönetimi')
@section('content')
    <h1 class="page-header">Ürün Yönetimi</h1>

    <div class="well">
        <div class="btn-group pull-right">
            <a href="{{route('yonetim.urun.yeni')}}" class="btn btn-primary">Yeni Ürün</a>
        </div>
        <form method="post" action="{{route('yonetim.urun')}}" class="form-inline">
            {{csrf_field()}}
            <div class="form-group">
                <label for="aranan">Ara</label>
                <input type="text" class="form-control form-control-sm" name="aranan" id="aranan"
                       placeholder="Ürün Ara.." value="{{old('aranan')}}">
            </div>
            <button type="submit" class="btn btn-primary">Ara</button>
            <a href="{{route('yonetim.urun')}}" class="btn btn-primary">Temizle</a>
        </form>
    </div>
    <h4 class="sub-header"> Ürün Listesi </h4>
    @include('layouts.partials.alert')
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Ürün Resmi</th>
                <th>Ürün Adı</th>
                <th>Slug</th>
                <th>Fiyatı</th>
                <th>Kayıt Tarihi</th>
                <th></th>


            </tr>
            </thead>
            <tbody>
            @if(count($list)==0)
                <tr>
                    <td colspan="7" class="text-center">Kayıt Bulunamadı..</td>
                </tr>
                @endif
                @foreach($list as $urun)
                    <tr>
                        <th>{{$urun->id}}</th>
                        <th>
                            <img src="{{$urun->detay->urun_resmi !=null  ? '/uploads/urunler/' . $urun->detay->urun_resmi: 'https://via.placeholder.com/400x400?text=UrunResmi' }}" class="img-responsive" style="width: 120px;">
                        </th>
                        <th>{{$urun->urun_adi}}</th>
                        <th>{{$urun->slug}}</th>
                        <td>{{$urun->fiyat}}</td>
                        <td>{{$urun->olusturma_tarihi}}</td>
                        <td style="width: 100px">
                            <a href="{{route('yonetim.urun.duzenle',$urun->id)}}" class="btn btn-xs btn-success"
                               data-toggle="tooltip" data-placement="top"
                               title="Düzenle">
                                <span class="fa fa-pencil"></span>
                            </a>
                            <a href="{{route('yonetim.urun.sil', $urun->id)}}" class="btn btn-xs btn-danger"
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
