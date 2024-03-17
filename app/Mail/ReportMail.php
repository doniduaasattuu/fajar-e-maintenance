<?php

namespace App\Mail;

use App\Http\Controllers\PdfController;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ReportMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(private PdfController $pdfController)
    {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Testing daily email reporting',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.report',
            with: [
                'title' => "EI Preventive Daily Report",
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $yesterday = Carbon::now()->addDays(-1)->format('d M Y');
        $tables = ['Motor', 'Trafo'];

        $this->pdfController->storeDailyReport($yesterday, $tables);

        $attachments = [];

        foreach ($tables as $table) {
            array_push($attachments, Attachment::fromStorageDisk('public', "daily-report/$yesterday/$table daily report - $yesterday.pdf")->withMime('application/pdf'));
        }

        return $attachments;
        // return [
        //     Attachment::fromStorageDisk('public', "daily-report/$yesterday/Trafo daily report - $yesterday.pdf")->withMime('application/pdf'),
        // ];
    }
}
