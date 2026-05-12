<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::latest();

        // Search by name or email
        if ($request->has('search')) {
            $query->where('full_name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $users = $query->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function toggleRole(User $user)
    {
        // Prevent admin from demoting themselves
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot change your own role.');
        }

        $user->role = ($user->role === 'admin') ? 'user' : 'admin';
        $user->save();

        return redirect()->back()->with('success', "Role updated for {$user->full_name}.");
    }

    public function verifyVolunteer(User $user)
    {
        // Toggle the is_volunteer status (manually verify/unverify)
        $user->is_volunteer = !$user->is_volunteer;
        $user->save();

        return redirect()->back()->with('success', 'Volunteer status updated.');
    }
}
