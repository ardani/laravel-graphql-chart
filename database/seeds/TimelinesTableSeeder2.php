<?php

use Illuminate\Database\Seeder;

class TimelinesTableSeeder2 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Timeline::class, 50)->create(['type' => 2]);
    }
}
