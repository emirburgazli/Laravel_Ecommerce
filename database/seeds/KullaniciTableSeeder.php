<?php

use App\Models\Kullanici;
use App\Models\KullaniciDetay;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KullaniciTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker\Generator $faker)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Kullanici::truncate();
        KullaniciDetay::truncate();

        $kullanici_yonetici = Kullanici::create([
            'adsoyad' => 'Emir Burgazlı',
            'mail' => 'emirhanburgazli@gmail.com',
            'sifre' => bcrypt('123456'),
            'aktif_mi' => 1,
            'yonetici_mi' => 1
        ]);
        $kullanici_yonetici->detay()->create([
            'adres' => 'İzmir',
            'telefon' => '(553) 721 70 71',
            'ceptelefonu' => '(553) 721 70 71'
        ]);

        for ($i = 0; $i < 50; $i++) {
            $kullanici_musteri = Kullanici::create([
                'adsoyad' => $faker->name,
                'mail' => $faker->unique()->email,
                'sifre' => bcrypt('123456'),
                'aktif_mi' => rand(0, 1),
                'yonetici_mi' => 0
            ]);
            $kullanici_musteri->detay()->create([
                'adres' => $faker->address,
                'telefon' => $faker->e164PhoneNumber,
                'ceptelefonu' => $faker->e164PhoneNumber
            ]);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
