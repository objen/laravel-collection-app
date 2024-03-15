<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SetSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 1000; $i++) {
            DB::table('sets')->insert([
                'name' => Str::random(20),
                'released' => rand(1970, 2024),
                'pieces' => rand(20, 10000),
                'rating' => rand(0, 10),
                'description' => Str::random(200),
                'owned' => rand(0, 1) == 1,
                'theme' => Str::random(10),
                'img_url' => Str::random(40),
            ]);
        }
    }
}
