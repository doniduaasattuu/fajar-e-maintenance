<?php

namespace App\Jobs;

use App\Mail\ReportMail;
use App\Mail\WelcomeMail;
use App\Models\EmailRecipient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $title = "EI Preventive Daily Report";
        $recipients = EmailRecipient::all();

        foreach ($recipients as $recipient) {
            Mail::to($recipient->email)->send(new ReportMail($title));
        }
    }
}
