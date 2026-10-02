<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessage;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Send email to hotel owner
        Mail::to('muhammadarkanfauzi@gmail.com')->send(new ContactMessage($validated));

        return back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }
}
