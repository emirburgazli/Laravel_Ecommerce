<h1>{{config('app.name')}}</h1>
<p>Merhaba {{$kullanici->adsoyad }} Kaydınız Başarılı bir şekilde yapıldı.</p>
<p>Kullanıcı kaydınızı aktifleştirmek için <a href="{{config('app.url')}}kullanici/aktiflestir/{{$kullanici->aktivasyon_anahtari}}">TIKLAYINIZ</a> veya aşağıdaki bağlantıyı tarayıcınızda açınız.</p>
<p>{{config('app.url')}}kullanici/aktiflestir/{{$kullanici->aktivasyon_anahtari}}</p>

