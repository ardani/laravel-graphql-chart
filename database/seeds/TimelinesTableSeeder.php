<?php

use Illuminate\Database\Seeder;

class TimelinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Timeline::class, 50)->create(['type' => 1]);
        factory(App\Timeline::class, 50)->create(['type' => 2]);
    }
}
