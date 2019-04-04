<?php

use Illuminate\Database\Seeder;

class VideosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            DB::table('videos')->insert([
                'name' => Str::random(10),
                'user_id' => collect([2, 3, 4])->random()
            ]);
        }
    }
}
