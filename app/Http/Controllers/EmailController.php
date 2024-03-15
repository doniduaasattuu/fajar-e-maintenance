<?php

namespace App\Http\Controllers;

use App\Data\Modal;
use App\Mail\ReportEmail;
use App\Mail\WelcomeMail;
use App\Models\EmailRecipient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class EmailController extends Controller
{
    public function sendWelcomeEmail()
    {
        $title = 'Welcome to Fajar E-Maintenance';
        $body = 'Thank you for providing web hosting';

        Mail::to('elc357@fajarpaper.com')->send(new WelcomeMail($title, $body));

        return 'Email sent successfully!';
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

    public function subscribe(Request $request)
    {
        $user = Auth::user();
        $email = $request->input('email');
        $name = $request->input('name');

        if ($user->email_address == $email && $user->fullname == $name) {

            $validated = $request->validate([
                'email' => ['required', 'email', 'ends_with:@fajarpaper.com,@gmail.com', 'exists:App\Models\User,email_address'],
                'name' => ['required'],
            ]);

            EmailRecipient::create($validated);
            return back();
        } else if ($user->isSuperAdmin()) {

            $validated = $request->validate([
                'email' => ['required', 'email', 'ends_with:@fajarpaper.com,@gmail.com'],
                'name' => ['nullable'],
            ]);

            EmailRecipient::create($validated);
            return back()->with('modal', new Modal('[204] Success', 'Successfully subscribed.'));
        } else {
            return back()->with('modal', new Modal('[403] Forbidden', 'You are not allowed to perform this operation!'));
        }
    }

    public function unsubscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'exists:App\Models\EmailRecipient,email'],
        ]);

        $recipient = EmailRecipient::query()->find($validated['email']);

        if (is_null($recipient)) {
            return back()->with('modal', new Modal('[404] Not found', 'Email not found.'));
        }

        $recipient->delete();
        return back();
    }

    public function sendReportEmail()
    {
        $value = 'doni.duaasattuu@gmail.com';
        $email = User::query()->where('email', $value)->first();
        return response()->json(!is_null($email));

        // $recipients = EmailRecipient::select('email')->get();
        // $recipients = $recipients->map(function ($user) {
        //     return $user->email;
        // });

        // $subscribe = EmailRecipient::query()->find(null);
        // return response()->json(!is_null($subscribe));

        // foreach ($recipients as $recipient) {
        //     Mail::to($recipient)->send(new ReportEmail());
        // }
    }
}
