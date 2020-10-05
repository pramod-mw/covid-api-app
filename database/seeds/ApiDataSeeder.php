<?php

use Illuminate\Database\Seeder;

class ApiDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('api_data')->insert([
            'date' => Str::random(10),
            'tested' => Str::random(10),
            'confirmed' => Str::random(10),
            'recovered' => Str::random(10).'@gmail.com',
            'deaths' => Hash::make('password'),
        ]);
    }
}
