<?php
namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\FactChecker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FactCheckerController extends Controller
{
    public function vote(Request $request, Campaign $campaign)
    {
        $request->validate([
            'vote' => 'required|in:1,-1', // 1 for Trust, -1 for Flag/Distrust
        ]);

        // Prevent creators from voting on their own campaigns
        if ($campaign->creator_by === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot verify your own campaign.');
        }

        // Use updateOrCreate to ensure one vote per user per campaign
        FactChecker::updateOrCreate(
            ['user_id' => Auth::id(), 'campaign_id' => $campaign->id],
            ['vote' => $request->vote]
        );

        $message = $request->vote == 1 ? 'Trust vote cast!' : 'Campaign flagged for review.';

        return redirect()->back()->with('success', $message);
    }
}
