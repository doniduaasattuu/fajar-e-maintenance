<?php

namespace App\Console\Commands;

use App\Jobs\SendEmailJob;
use App\Mail\ReportMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-email-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily report email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        SendEmailJob::class;
        // $title = "EI Preventive Daily Report";
        // Mail::to('elc357@fajarpaper.com')->send(new ReportMail($title));
    }
}
