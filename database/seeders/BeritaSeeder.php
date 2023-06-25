<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker;
use DB;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $userIDs = DB::table('users')->pluck('id');
        $kategoriIDs = DB::table('categories')->pluck('id');


        for ($i = 0; $i < 5000; $i++) {
            $judul = $faker->sentence();
            $data[$i] = [
                'judul' => $judul,
                'tanggal' => $faker->dateTimeBetween('-1 month', '+1 day'),
                'isi_berita' => $faker->paragraph(),
                'slug' => \Str::slug($judul),
                'gambar' => 'https://source.unsplash.com/random/1024x768/?portrait',
                'thumbnail' => 'https://source.unsplash.com/random/128x80/?portrait',
                'tags' => $faker->word(),
                'kategori_id' => $faker->randomElement($kategoriIDs),
                'user_id' => $faker->randomElement($userIDs),
                'created_at' => $faker->dateTimeBetween('-2 month', '+1 day'),


            ];
        }
        DB::table('beritas')->insert($data);

    }
}