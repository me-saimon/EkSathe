<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CampaignStreamController extends Controller
{
    public function startStream(Campaign $campaign)
    {
        if ($campaign->creator_by !== auth()->id()) abort(403);

        $campaign->update([
            'is_live' => true,
            'stream_key' => $campaign->stream_key ?? Str::random(20)
        ]);

        return redirect()->back()->with('success', 'You are now LIVE. Use your stream key in OBS to start broadcasting.');
    }

    public function stopStream(Campaign $campaign)
    {
        if ($campaign->creator_by !== auth()->id()) abort(403);

        $campaign->update(['is_live' => false]);

        return redirect()->back()->with('success', 'Live stream ended.');
    }
}
