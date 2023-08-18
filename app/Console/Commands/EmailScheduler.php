<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendNewCoursesEmailJob;

class EmailScheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedule the new courses availability email sending job';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('New courses availability email sending job scheduled.');

        $emailJob = new SendNewCoursesEmailJob();
        dispatch($emailJob);
    }
}
