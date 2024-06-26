<?php

namespace App\Jobs;

use App\Http\Controllers\PdfController;
use App\Mail\ReportMail;
use App\Mail\WelcomeMail;
use App\Models\EmailRecipient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
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
        $recipients = EmailRecipient::all();

        foreach ($recipients as $recipient) {
            Mail::to($recipient->email)->send(new ReportMail(new PdfController()));
        }
    }
}
