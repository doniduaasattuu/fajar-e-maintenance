<?php

namespace App\Http\Controllers;

use App\Data\Modal;
use App\Mail\ReportEmail;
use App\Mail\WelcomeMail;
use App\Models\EmailRecipient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendWelcomeEmail()
    {
        $title = 'Welcome to Fajar E-Maintenance';
        $body = 'Thank you for providing web hosting';

        Mail::to('elc357@fajarpaper.com')->send(new WelcomeMail($title, $body));

        return 'Email sent successfully!';
    }

    public function sendReportEmail()
    {
        $title = 'Fajar E-Maintenance';
        $recipients = EmailRecipient::get();

        foreach ($recipients as $recipient) {
            Mail::to($recipient)->send(new ReportEmail($title));
        }
    }

    public function emailRecipients(Request $request)
    {
        $search = $request->query('search');

        $paginator = EmailRecipient::query()
            ->when($search, function ($query, $search) {
                $query
                    ->where('email', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(5)
            ->withQueryString();

        return view('auth.recipients', [
            'title' => 'Email Recipients',
            'paginator' => $paginator,
        ]);
    }

    public function addRecipients(Request $request)
    {
        if (!is_null(EmailRecipient::find($request->input('email')))) {
            return back()->with('modal', new Modal('[403] Forbidden', 'Recipient already subscribed.'));
        }

        $validated = $request->validate([
            'email' => ['required', 'email']
        ]);

        EmailRecipient::create($validated);

        return back()->with('modal', new Modal('[204] Success', 'Successfully subscribed.'));
    }

    public function deleteRecipients(string $email)
    {
        $recipient = EmailRecipient::find($email);

        if (is_null($recipient)) {
            return back()->with('modal', new Modal('[404] Not found', 'Recipient not found.'));
        } else {
            $recipient->delete();
            return back()->with('modal', new Modal('[204] Success', 'Successfully unsubscribed.'));
        }
    }
}
