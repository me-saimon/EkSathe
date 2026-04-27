<?php

namespace App\Http\Controllers;

use App\Models\HelpRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HelpRequestController extends Controller
{
    public function create()
    {
        return view('help.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:50',
            'location' => 'required|string|max:255',
            'contact_info' => 'required|string|max:100',
        ]);

        HelpRequest::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'message' => $request->message,
            'location' => $request->location,
            'contact_info' => $request->contact_info,
            'status' => 'new',
        ]);

        return redirect()->route('dashboard')->with('success', 'Your request has been sent to our admin team. We will contact you soon.');
    }
}
