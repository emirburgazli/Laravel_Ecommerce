@extends('yonetim.layouts.master')
@section('title','Kullanıcı Yönetimi')
@section('content')
    <h1 class="page-header">Kullanıcı Yönetimi</h1>
    <h1 class="sub-header">
        <div class="btn-group pull-right" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-primary">Print</button>
            <button type="button" class="btn btn-primary">Export</button>
        </div>
        <h4> Kullanıcı Listesi</h4>


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
                </tr>
                </thead>
                <tbody>
                @foreach($list as $kullanici)
                    <tr>
                        <td>{{$kullanici->id}}</td>
                        <td>{{$kullanici->adsoyad}}</td>
                        <td>{{$kullanici->mail}}</td>
                        <td>
                            @if($kullanici->aktif_mi)
                                <span class="label label-success">Aktif</span>
                            @else
                                <span class="label label-success">Pasif</span>
                                @endif
                        </td>
                        <td>
                            @if($kullanici->yonetici_mi)
                                <span class="label label-success">Yönetici</span>
                            @else
                                <span class="label label-success">Müşteri</span>
                                @endif
                        </td>
                        <td style="width: 100px">
                            <a href="{{route('yonetim.kullanici.duzenle',$kullanici->id)}}" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top"
                               title="Duzenle">
                                <span class="fa fa-pencil"></span>
                            </a>
                            <a href="#" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top"
                               title="Sil" onclick="return confirm('Emin Misiniz?')">
                                <span class="fa fa-trash"></span>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
@endsection
