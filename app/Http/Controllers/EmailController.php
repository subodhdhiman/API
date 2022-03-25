<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail as FacadesMail;
use Mail;

class EmailController extends Controller
{
    public function create()
    {

        return response()->json('Mail Created', 205);
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'subject' => 'required',
            'content' => 'required',
        ]);

        $data = [
            'subject' => $request->subject,
            'email' => $request->email,
            'content' => $request->content
        ];

        FacadesMail::send('email-template', $data, function ($message) use ($data) {
            $message->to($data['email'])
                ->subject($data['subject']);
        });

        return response()->json('Mail Sent', 205);
    }
}
