@extends('yonetim.layouts.master')
@section('title','Anasayfa')
@section('content')
    <h1 class="page-header">Kontrol Paneli</h1>
    <section class="row text-center placeholders">
        <div class="col-6 col-sm-3">
            <div class="panel panel-info">
                <div class="panel-heading">Aktif Kullanıcı Sayısı</div>
                <div class="panel-body">
                    <h4>{{ $aktif_kullanici  }} </h4>
                    <p>Adet</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="panel panel-info">
                <div class="panel-heading">Pasif Kullanıcı Sayısı</div>
                <div class="panel-body">
                    <h4>{{ $pasif_kullanici}}</h4>
                    <p>Adet</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="panel panel-info">
                <div class="panel-heading">Toplam Kullanıcı Sayısı</div>
                <div class="panel-body">
                    <h4>{{ $istatistikler['toplam_kullanici']}}</h4>
                    <p>Adet</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="panel panel-info">
                <div class="panel-heading">Toplam Kazanç</div>
                <div class="panel-body">
                    <h4>{{ $toplam_kazanc }} ₺</h4>
                    <p>Türk Lirası</p>
                </div>
            </div>
        </div>
    </section>

    <section class="row">
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Çok Satılan Ürünler (BAR)</div>
                <div class="panel-body">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Çok Satılan Ürünler (PİE)</div>
                <div class="panel-body">
                    <canvas id="myCharts"></canvas>
                </div>
            </div>
        </div>
    </section>
    <h1 class="page-header">Ürün Takip Paneli</h1>
    <section class="row text-center placeholders">
        <div class="col-6 col-sm-3">
            <div class="panel panel-info">
                <div class="panel-heading">Alınan Siparişler</div>
                <div class="panel-body">
                    <h4>{{ $istatistikler['bekleyen_siparisler']}}</h4>
                    <p>Adet</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="panel panel-success">
                <div class="panel-heading">Ödemesi Onaylanan Siparişler</div>
                <div class="panel-body">
                    <h4>{{ $istatistikler['odemesi_onaylanan_siparisler']}}</h4>
                    <p>Adet</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="panel panel-success">
                <div class="panel-heading">Kargoya Verilen Siparişler</div>
                <div class="panel-body">
                    <h4>{{ $istatistikler['kargoya_verilen_siparisler']}}</h4>
                    <p>Adet</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Tamamlanan Siparişler</div>
                <div class="panel-body">
                    <h4>{{ $istatistikler['tamamlanan_siparisler']}}</h4>
                    <p>Adet</p>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
    @php
        $labels = "";
        $data = "";
        foreach ($cok_satan_urunler as $rapor){
            $labels .= "\"$rapor->urun_adi\",";
            $data .= "$rapor->adet,";
        }
    @endphp
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [{!! $labels !!}],
                datasets: [{
                    label: 'Çok Satılan Ürünler',
                    data: [{!!$data!!}],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

            @php
                $labels = "";
                $data = "";
                foreach ($aylara_gore_satis as $rapor){
                    $labels .= "\"$rapor->ay\",";
                    $data .= "$rapor->adet,";
                }
            @endphp
        var ctx2 = document.getElementById('myCharts').getContext('2d');
        var myChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: [{!! $labels !!}],
                datasets: [{
                    label: 'Aylara Göre Satışlar',
                    data: [{!!$data!!}],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
@endsection
