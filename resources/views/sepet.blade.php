@extends('layout.master')
@section('title','Sepet')
@section('content')
    <div class="container">
        <div class="bg-content">
            <h2>Sepet</h2>
            @include('layout.partials.alert')
            <table class="table table-bordererd table-hover">
                <tr>
                    <th colspan="2">Ürün</th>
                    <th>Adet Fiyatı</th>
                    <th>Adet</th>
                    <th>Tutar</th>

                </tr>

                @foreach(Cart::Content() as $urunCartItem)
                    <tr>
                        <td style="width: 120px;">
                            <img src="https://via.placeholder.com/120x100?text=UrunResmi">
                        </td>
                        <td>{{$urunCartItem->name}}</td>
                        <td>{{$urunCartItem->price}} ₺</td>
                        <td>
                            <a href="#" class="btn btn-xs btn-default">-</a>
                            <span style="padding: 10px 20px">{{$urunCartItem->qty}}</span>
                            <a href="#" class="btn btn-xs btn-default">+</a>
                        </td>
                        <td class="text-right">
                            {{$urunCartItem->subtotal}} ₺
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="4" class="text-right">Toplam Tutar</th>
                    <td class="text-right">{{ Cart::subtotal() }} ₺</td>
                </tr>
                <tr>
                    <th colspan="4" class="text-right">KDV</th>
                    <td class="text-right">{{ (Cart::subtotal() * 18)/100 }} ₺</td>
                </tr>
                <tr>
                    <th colspan="4" class="text-right">Toplam Tutar (KDV Dahil)</th>
                    <td class="text-right">{{  Cart::subtotal() + (Cart::subtotal() * 18)/100 }} ₺</td>
                </tr>
            </table>
            <div>
                <a href="#" class="btn btn-info pull-left">Sepeti Boşalt</a>
                <a href="#" class="btn btn-success pull-right btn-lg">Ödeme Yap</a>
            </div>
        </div>
    </div>
@endsection
