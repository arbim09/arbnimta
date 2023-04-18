<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use Yajra\Datatables\Datatables;

class ContactController extends Controller
{
    /**
     * Show the form for creating a new contact message.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contact');
    }

    /**
     * Store a newly created contact message in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'no_hp' => 'required',
            'subject' => 'required',
            'message' => 'required'
        ]);

        $data = array(
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'subject' => $request->subject,
            'message' => $request->message
        );

        Mail::to('contohpunyaarya123@gmail.com')->send(new ContactFormMail($data));

        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'subject' => $request->subject,
            'message' => $request->message
        ]);

        return redirect()->back()->with('success', 'Pesan Anda berhasil terkirim!');
    }

   
}
