<?php

namespace Database\Seeders;

use App\Models\GeneralSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GeneralSettings extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('general_settings')->truncate();

        $settings = [
            [
                'title' => 'Landing Page Video',
                'key' => 'landing_page_video',
                'value' => 'https://www.youtube.com/watch?v=sIBcQil9ARA'
            ],
            [
                'title' => 'Booking Credits Price',
                'key' => 'booking_credits_price',
                'value' => '50'
            ],
            [
                'title' => 'Instagram Link',
                'key' => 'instagram_link',
                'value' => 'https://www.instagram.com/speak2impact/'
            ],
            [
                'title' => 'TikTok Link',
                'key' => 'tiktok_link',
                'value' => 'https://www.tiktok.com/@smashfield89'
            ],
            [
                'title' => 'LinkedIn Link',
                'key' => 'linkedin_link',
                'value' => 'https://www.linkedin.com/in/susannahashfield/'
            ]
        ];
        GeneralSetting::insert($settings);
    }
}
