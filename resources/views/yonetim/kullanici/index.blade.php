@extends('yonetim.layouts.master')
@section('title','Kullanıcı Yönetimi')
@section('content')
    <h1 class="page-header">Kullanıcı Yönetimi</h1>

    <div class="well">
        <div class="btn-group pull-right">
            <a href="{{route('yonetim.kullanici.yeni')}}" class="btn btn-primary">Yeni Kullanıcı</a>
        </div>
        <form method="post" action="{{route('yonetim.kullanici')}}" class="form-inline">
            {{csrf_field()}}
            <div class="form-group">
                <label for="aranan">Ara</label>
                <input type="text" class="form-control form-control-sm" name="aranan" id="aranan" placeholder="Ad, Email ara.." value="{{old('aranan')}}">
            </div>
            <button type="submit" class="btn btn-primary">Ara</button>
            <a href="{{route('yonetim.kullanici')}}" class="btn btn-primary">Temizle</a>
        </form>
    </div>
    <h4 class="sub-header"> Kullanıcı Listesi </h4>
    @include('layouts.partials.alert')
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Ad Soyad</th>
                <th>Mail</th>
                <th>Aktif Mi ?</th>
                <th>Yönetici Mi ?</th>
                <th>Kayıt Tarihi</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @if(count($list)==0)
                <tr>
                    <td colspan="6" class="text-center">Kayıt Bulunamadı..</td>
                </tr>
            @endif
            @foreach($list as $kullanici)
                <tr>
                    <td>{{$kullanici->id}}</td>
                    <td>{{$kullanici->adsoyad}}</td>
                    <td>{{$kullanici->mail}}</td>
                    <td>
                        @if($kullanici->aktif_mi)
                            <span class="label label-success">Aktif</span>
                        @else
                            <span class="label label-danger">Pasif</span>
                        @endif
                    </td>
                    <td>
                        @if($kullanici->yonetici_mi)
                            <span class="label label-success">Yönetici</span>
                        @else
                            <span class="label label-warning">Müşteri</span>
                        @endif
                    </td>
                    <th>{{$kullanici->olusturma_tarihi}}</th>
                    <td style="width: 100px">
                        <a href="{{route('yonetim.kullanici.duzenle',$kullanici->id)}}" class="btn btn-xs btn-success"
                           data-toggle="tooltip" data-placement="top"
                           title="Düzenle">
                            <span class="fa fa-pencil"></span>
                        </a>
                        <a href="{{route('yonetim.kullanici.sil', $kullanici->id)}}" class="btn btn-xs btn-danger"
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
