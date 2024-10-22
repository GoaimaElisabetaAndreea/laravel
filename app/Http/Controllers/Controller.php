<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

class Controller
{
    public function home()
    {
//        Mail::send('emails.auth.test', ['name' => 'Alex'], function($message) {
//            $message->to('elisabetagoaima@gmail.com', 'Alex Garret')
//                    ->subject('Test email');
//        });

        return view('home');
    }
}

