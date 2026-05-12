<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\HelpRequest;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_raised' => Donation::where('status', 'verified')->sum('amount'),
            'active_campaigns' => Campaign::where('status', 'active')->count(),
            'pending_help' => HelpRequest::where('status', 'new')->count(),
            'total_users' => User::count(),
        ];

        // Recent Help Requests
        $recentRequests = HelpRequest::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentRequests'));
    }
}
