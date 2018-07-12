<?php

use Illuminate\Database\Seeder;

class FeedsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Feed::class, 70)->create()->each(function($feed){
            $retweet = array_random([0, 1, 2, 3, 4, 0, 4, 5, 0, 0]);
            $user = App\User::inRandomOrder()->first();
            if ($retweet) {
                $feed->create([
                    'message' => null,
                    'type' => 1,
                    'user_id' => $user->id,
                    'parent_id' => $feed->id
                ]);
            }
        });
    }
}
