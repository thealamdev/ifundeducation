<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Rules\ReCaptcha;
use Illuminate\Http\Request;

class ContactMessageController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $contactMessages     = ContactMessage::orderBy('id', 'desc')->paginate(15);
        $totalUnreadMessages = unreadContactMessageCount();
        return view('backend.contact_message.index', compact('contactMessages', 'totalUnreadMessages'));
    }

    /**
     * Search resource in storage & Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $totalUnreadMessages = ContactMessage::where('status', 'unread')->count();

        if ($request->search) {
            $contactMessages = ContactMessage::where('your_name', 'LIKE', '%' . $request->search . '%')->
                orWhere('your_email', 'LIKE', '%' . $request->search . '%')->
                orWhere('subject', 'LIKE', '%' . $request->search . '%')->
                orWhere('message', 'LIKE', '%' . $request->search . '%')->
                orderBy('id', 'desc')->paginate(15);

            return view('backend.contact_message.index', compact('contactMessages', 'totalUnreadMessages'));
        } else {
            $contactMessages = ContactMessage::orderBy('id', 'desc')->paginate(15);
            return view('backend.contact_message.index', compact('contactMessages', 'totalUnreadMessages'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        // dd($request->all());
        $request->validate([
            "your_name"            => 'required|max:255',
            "your_email"           => 'required|max:255',
            'g-recaptcha-response' => ['required', new ReCaptcha],
        ]);

        $insert = ContactMessage::create([
            'your_name'  => $request->your_name,
            'your_email' => $request->your_email,
            'subject'    => $request->subject,
            'message'    => $request->message,
            'status'     => 'unread',
        ]);

        if ($insert) {
            return back()->with('success', 'Your Message Sent Successful!');
        } else {
            return back()->with('error', 'Your Message Sent Error!');
        }

        // return redirect()->back()->with(['success' => 'Contact Form Submit Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContactMessage  $contactMessage
     * @return \Illuminate\Http\Response
     */
    public function show(ContactMessage $contactMessage) {
        $contactMessage->update([
            'status' => 'read',
        ]);

        return view('backend.contact_message.view', compact('contactMessage'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContactMessage  $contactMessage
     * @return \Illuminate\Http\Response
     */
    public function edit(ContactMessage $contactMessage) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContactMessage  $contactMessage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContactMessage $contactMessage) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContactMessage  $contactMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactMessage $contactMessage) {
        //
    }

    public function permanentDestroy($id) {
        $data = ContactMessage::where('id', $id)->first();
        $data->forceDelete();
        return redirect(route('dashboard.contact-messages.index'))->with('success', 'Contact Message Permanent Delete Successful! [ID: ' . $id . ']');
    }

}
