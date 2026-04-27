<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    // Show the form
    public function create()
    {
        return view('campaigns.create');
    }

    // Store the data
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'campaign_date' => 'required|date',
            'goal_amount' => 'nullable|numeric',
            'address' => 'required|string',
            'banner_image' => 'required|image|mimes:jpg,jpeg,png|max:2048', // 2MB Max
            'is_volunteer_need' => 'nullable|boolean',
        ]);

        // Handle Image Upload
        $imagePath = $request->file('banner_image')->store('campaign_banners', 'public');

        Campaign::create([
            'creator_by' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'campaign_date' => $request->campaign_date,
            'goal_amount' => $request->goal_amount ?? 0,
            'address' => $request->address,
            'live_video_url' => $request->live_video_url,
            'location_map' => $request->location_map,
            'banner_image' => $imagePath,
            'is_volunteer_need' => $request->has('is_volunteer_need') ? 1 : 0,
            'status' => 'active',
        ]);

        return redirect()->route('dashboard')->with('status', 'Campaign Created Successfully!');
    }
}
