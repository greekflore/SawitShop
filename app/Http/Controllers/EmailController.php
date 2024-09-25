<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmail()
    {
        Mail::raw('This is a test email', function ($message) {
            $message->to('test@example.com')
                    ->subject('Test Email from Laravel');
        });

        return 'Email sent successfully!';
    }
}
