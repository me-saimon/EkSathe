<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class AdminDonationController extends Controller
{
    public function index(Request $request)
    {
        $query = Donation::with(['user', 'campaign'])->latest();

        // Search by Transaction ID
        if ($request->has('search')) {
            $query->where('transaction_id', 'like', '%' . $request->search . '%');
        }

        // Filter by Status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $donations = $query->paginate(15);

        // Stats for the header
        $totalRevenue = Donation::where('status', 'verified')->sum('amount');
        $successRate = Donation::count() > 0
            ? round((Donation::where('status', 'verified')->count() / Donation::count()) * 100)
            : 0;

        return view('admin.donations.index', compact('donations', 'totalRevenue', 'successRate'));
    }
}
