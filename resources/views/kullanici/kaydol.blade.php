@extends('layout.master')
@section('title','Kaydol')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Kaydol</div>
                    <div class="panel-body">

                        <form class="form-horizontal" role="form" method="POST"
                              action="{{ route('kullanici.kaydol') }}">
                            {{ csrf_field() }}
                            <div class="form-group {{ $errors->has('adsoyad') ? 'has-error' : '' }}">
                                <label for="adsoyad" class="col-md-4 control-label">Ad Soyad</label>
                                <div class="col-md-6">
                                    <input id="adsoyad" type="text" class="form-control" name="adsoyad" value=""
                                           required autofocus>
                                    @if($errors->has('adsoyad'))
                                        <span class="help-block">
                                            <strong>{{$errors->first('adsoyad')}} </strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('mail') ? 'has-error' : '' }}">
                                <label for="mail" class="col-md-4 control-label">Email</label>
                                <div class="col-md-6">
                                    <input id="mail" type="email" class="form-control" name="mail"
                                           value="{{old('mail')}}" required>
                                    @if($errors->has('mail'))
                                        <span class="help-block">
                                            <strong>{{$errors->first('mail')}} </strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('sifre') ? 'has-error' : '' }}">
                                <label for="sifre" class="col-md-4 control-label">Şifre</label>
                                <div class="col-md-6">
                                    <input id="sifre" type="password" class="form-control" name="sifre" required>
                                    @if($errors->has('sifre'))
                                        <span class="help-block">
                                            <strong>{{$errors->first('sifre')}} </strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="sifre_confirmation" class="col-md-4 control-label">Şifre (Tekrar)</label>
                                <div class="col-md-6">
                                    <input id="sifre_confirmation" type="password" class="form-control"
                                           name="sifre_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Kaydol
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
