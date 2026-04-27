<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;

class CampaignController extends Controller
{


    public function landing()
    {
        // Fetch only 3 featured campaigns for the landing page
        $featuredCampaigns = Campaign::with('creator')->where('status', 'active')->latest()->take(3)->get();
        return view('welcome', compact('featuredCampaigns'));
    }

    public function index(Request $request)
    {
        $query = Campaign::with('creator')->where('status', 'active');

        // Simple Filter Logic
        if ($request->has('category') && $request->category != 'All') {
            $query->where('category', $request->category);
        }

        $campaigns = $query->latest()->paginate(9);
        return view('campaigns.index', compact('campaigns'));
    }


    public function create()
    {
        return view('campaigns.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string',
            'campaign_date' => 'required|date',
            'goal_amount' => 'required|numeric|min:0',
            'address' => 'required|string',
            'banner_image' => 'required|image|mimes:jpeg,png,jpg|max:5120', // 5MB Max
            'live_video_url' => 'nullable|url',
            'location_map' => 'nullable|string',
        ]);

        // Handle Banner Upload
        $path = $request->file('banner_image')->store('campaign_banners', 'public');

        Campaign::create([
            'creator_by' => Auth::id(),
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
            'campaign_date' => $request->campaign_date,
            'goal_amount' => $request->goal_amount,
            'address' => $request->address,
            'live_video_url' => $request->live_video_url,
            'location_map' => $request->location_map,
            'banner_image' => $path,
            'is_volunteer_need' => $request->has('is_volunteer_need') ? 1 : 0,
            'status' => 'active',
        ]);

        return redirect()->route('campaigns.index')->with('success', 'Your impact journey has started!');
    }


    public function show(Campaign $campaign)
    {
        // Eager load relationships for speed
        $campaign->load(['creator', 'donations', 'progressUpdates.creator', 'volunteerApplications']);

        $totalDonated = $campaign->donations->where('status', 'verified')->sum('amount');
        $progressPercent = $campaign->goal_amount > 0 ? min(100, ($totalDonated / $campaign->goal_amount) * 100) : 0;

        return view('campaigns.show', compact('campaign', 'totalDonated', 'progressPercent'));
    }


    public function myCampaigns()
{
    $campaigns = Auth::user()->campaigns()
        ->withCount(['volunteerApplications'])
        ->withSum('donations as total_raised', 'amount')
        ->latest()
        ->paginate(10);

    return view('campaigns.manage', compact('campaigns'));
}



public function edit(Campaign $campaign)
{
    // Authorization Check
    // if ($campaign->creator_by !== Auth::id()) {
    //     abort(403, 'Unauthorized action.');
    // }

    return view('campaigns.edit', compact('campaign'));
}

public function update(Request $request, Campaign $campaign)
{
    // Authorization Check
    // if ($campaign->creator_by !== Auth::id()) {
    //     abort(403);
    // }

    $request->validate([
        'title' => 'required|string|max:255',
        'category' => 'required|string',
        'description' => 'required|string',
        'campaign_date' => 'required|date',
        'goal_amount' => 'required|numeric|min:0',
        'address' => 'required|string',
        'banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // Nullable on Edit
        'live_video_url' => 'nullable|url',
        'location_map' => 'nullable|string',
    ]);

    $data = $request->except('banner_image');
    $data['is_volunteer_need'] = $request->has('is_volunteer_need') ? 1 : 0;

    // Handle Image Update
    if ($request->hasFile('banner_image')) {
        // Delete the old image from storage
        if ($campaign->banner_image) {
            Storage::disk('public')->delete($campaign->banner_image);
        }
        // Store the new image
        $data['banner_image'] = $request->file('banner_image')->store('campaign_banners', 'public');
    }

    $campaign->update($data);

    return redirect()->route('campaigns.mine')->with('success', 'Campaign updated successfully!');
}



public function toggleStatus(Request $request, Campaign $campaign)
{
    // Authorization check
    if ($campaign->creator_by !== Auth::id()) {
        abort(403);
    }

    $request->validate(['status' => 'required|in:active,paused,completed']);

    $campaign->update(['status' => $request->status]);

    return redirect()->back()->with('success', 'Campaign status updated to ' . $request->status);
}



    // Show the form


    // Store the data

}
