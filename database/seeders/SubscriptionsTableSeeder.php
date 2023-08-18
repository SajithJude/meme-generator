<?php

namespace Database\Seeders;

use App\Models\Subscription;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubscriptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            [
                'plans' => 'yearly',
                'discount_percentage' => 30,
                'is_access_cource' => 1,
                'duration' => 20,
                'feedback_video_count' => 5,
                'webinar_access' => '1',
                'yoodli_access' => '1',
                'price' => 150,
                'booking_credit' => 2,
                'stripe_product_id' => 'prod_Ne2hSAHuvCd7dJ',
            ],[
                'plans' => 'yearly',
                'discount_percentage' => 30,
                'is_access_cource' => 1,
                'duration' => 40,
                'feedback_video_count' => 5,
                'webinar_access' => '1',
                'yoodli_access' => '1',
                'price' => 2000,
                'booking_credit' => 2,
                'stripe_product_id' => 'prod_Ne2hSAHuvCd7dJ',
            ]
        ];
        Subscription::insert($plans);
    }
}
