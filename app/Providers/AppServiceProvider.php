<?php

namespace App\Providers;

use App\Models\Ayar;
use App\Models\Kategori;
use App\Models\Kullanici;
use App\Models\Siparis;
use App\Models\Urun;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        View::composer('yonetim.*', function ($view) {
            $bitisZamani = now()->addMinutes(1);
            $istatistikler = Cache::remember('istatistikler', $bitisZamani, function () {
                return [
                    'bekleyen_siparisler' => Siparis::where('durum', 'Siparişiniz Alındı..')->count(),
                    'odemesi_onaylanan_siparisler' => Siparis::where('durum', 'Ödemeniz Onaylandı..')->count(),
                    'kargoya_verilen_siparisler' => Siparis::where('durum', 'Kargoya Verildi..')->count(),
                    'tamamlanan_siparisler' => Siparis::where('durum', 'Siparişiniz Tamamlandı..')->count(),
                    'toplam_urun' => Urun::count(),
                    'toplam_kategori' => Kategori::count(),
                    'toplam_kullanici' => Kullanici::count()
                ];
            });
            $view->with('istatistikler',$istatistikler);


        });

        foreach (Ayar::all() as $ayar) {
        Config::set('ayar'. $ayar->anahtar,$ayar->deger);
        }
    }
}
