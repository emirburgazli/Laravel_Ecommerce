<?php

use App\Models\Urun;
use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class UrunTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker\Generator $faker)
    {
        DB::table('urun')->truncate();
        for ($i =0;$i<30; $i++) {
            $urun_adi=$faker->sentence(2);
            DB::table('urun')->insert([
                'urun_adi' => $urun_adi,
                'slug' => strtolower($urun_adi),
                'acıklama'=>$faker->sentence(3),
                'fiyat'=>$faker->randomFloat(3,1,20)
            ]);
        }
    }
}
