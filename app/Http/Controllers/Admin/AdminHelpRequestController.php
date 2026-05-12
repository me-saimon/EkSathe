<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HelpRequest;
use Illuminate\Http\Request;

class AdminHelpRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = HelpRequest::with('user')->latest();

        // Optional Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $requests = $query->paginate(15);

        return view('admin.help-requests.index', compact('requests'));
    }

    public function updateStatus(Request $request, HelpRequest $helpRequest)
    {
        $request->validate([
            'status' => 'required|in:new,processing,resolved,closed'
        ]);

        $helpRequest->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Request status updated successfully.');
    }

    public function destroy(HelpRequest $helpRequest)
    {
        $helpRequest->delete();
        return redirect()->back()->with('success', 'Request removed from system.');
    }
}
