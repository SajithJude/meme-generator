<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Mail\NewCourseOpenEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendNewCoursesEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $today = Carbon::today();
        $day = $today->day;
        $users = User::whereHas('userSubscribedPlans', function ($query) use ($day, $today) {
            $query->whereDay('subscription_start_date', $day)
                ->where('subscription_start_date', '<', $today);
        })->get();
        
        foreach ($users as $user) {
            Mail::to($user->email)->send(new NewCourseOpenEmail());
        }
    }
}
