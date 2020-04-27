<?php

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

         $this->call(KategoriTableSeeder::class);
         $this->call(UrunTableSeeder::class);
    }
}
