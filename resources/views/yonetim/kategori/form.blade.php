@extends('yonetim.layouts.master')
@section('title','Kategori Yönetimi')
@section('content')
    <h1 class="page-header">Kategori Yönetimi</h1>
    <form method="post" action="{{ route('yonetim.kategori.kaydet' , @$kategori->id) }}">
        {{csrf_field()}}
        <div class="pull-right">
            <button type="submit" class="btn btn-primary">
                {{$kategori->id > 0 ? 'Güncelle' : 'Kaydet'}}
            </button>
        </div>
        <h4 class="sub-header">
            Kategori {{$kategori->id > 0 ?"Düzenle" : "Ekle"}}
</h4>
            @include('layouts.partials.errors')
            @include('layouts.partials.alert')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ust_id">Üst Kategori</label>
                        <select name="ust_id" id="ust_id" class="form-control">
                            @foreach($kategoriler as $entry)
                            <option value="{{$entry->id}}">{{$entry->kategori_adi}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kategori_adi">Kategori Adı</label>
                        <input type="text" class="form-control" name="kategori_adi" id="kategori_adi"
                               placeholder="Kategori Adı" value={{old('kategori_adi',$kategori->kategori_adi)}}>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input type="hidden" name="original_slug" value={{old('slug',$kategori->slug)}}>
                        <input type="text" class="form-control" name="slug" id="slug" placeholder="slug"
                               value={{old('slug',$kategori->slug)}} >
                    </div>
                </div>
            </div>
    </form>
@endsection

