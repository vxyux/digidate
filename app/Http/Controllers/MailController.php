<?php

namespace App\Http\Controllers;

use App\Mail\MailProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MailController extends Controller
{
    public function index()
    {
        $mailData = [
            'title' => 'Mail from DigiDate',
            'body' => 'This is your e-mail verification notice.',
            'code' => Str::random(8),
        ];

        Mail::to('00303916@rijnijssel.nl')->send(new MailProvider($mailData));

        dd("Email is sent successfully.");
    }
}
