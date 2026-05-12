<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;

class AdminCampaignController extends Controller
{
    public function index(Request $request)
    {
        $query = Campaign::with(['creator', 'factChecks'])
            ->withSum('donations as total_raised', 'amount');

        // Filter by Status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $campaigns = $query->latest()->paginate(10);

        return view('admin.campaigns.index', compact('campaigns'));
    }

    public function updateRank(Request $request, Campaign $campaign)
    {
        $request->validate(['rank' => 'required|integer|min:0|max:100']);
        $campaign->update(['rank' => $request->rank]);

        return redirect()->back()->with('success', 'Campaign rank updated.');
    }

    public function toggleStatus(Request $request, Campaign $campaign)
    {
        $request->validate(['status' => 'required|in:active,paused,completed']);
        $campaign->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Campaign status updated to ' . $request->status);
    }
}
