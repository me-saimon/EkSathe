<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\VolunteerApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VolunteerApplicationController extends Controller
{
    public function create(Campaign $campaign)
    {
        // Check if the campaign actually needs volunteers
        if (!$campaign->is_volunteer_need) {
            return redirect()->route('campaigns.show', $campaign)->with('error', 'This campaign is not accepting volunteers.');
        }

        // Check if user has already applied
        $alreadyApplied = VolunteerApplication::where('user_id', Auth::id())
                            ->where('campaign_id', $campaign->id)
                            ->exists();

        if ($alreadyApplied) {
            return redirect()->route('campaigns.show', $campaign)->with('info', 'You have already applied for this campaign.');
        }

        return view('volunteer.apply', compact('campaign'));
    }

    public function store(Request $request, Campaign $campaign)
    {
        $request->validate([
            'application_notes' => 'required|string|min:20',
        ]);

        VolunteerApplication::create([
            'user_id' => Auth::id(),
            'campaign_id' => $campaign->id,
            'application_notes' => $request->application_notes,
            'status' => 'pending',
        ]);

        return redirect()->route('campaigns.show', $campaign)->with('success', 'Application submitted! We will contact you soon.');
    }
}
