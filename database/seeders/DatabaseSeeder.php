<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\CoursesTableSeeder;
use Database\Seeders\SubscriptionsTableSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\User::factory(5)->create();
         \App\Models\Admin::factory(1)->create();
        $this->call(SubscriptionsTableSeeder::class);
        $this->call(CoursesTableSeeder::class);
    }
}
