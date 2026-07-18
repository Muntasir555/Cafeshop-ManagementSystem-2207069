<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $approvedUsers = User::where('role', 'customer')
            ->where('status', 'approved')
            ->when($search, fn ($q) => $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            }))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $pendingUsers = User::where('role', 'customer')
            ->where('status', 'pending')
            ->latest()
            ->get();

        $rejectedUsers = User::where('role', 'customer')
            ->where('status', 'rejected')
            ->latest()
            ->get();

        return view('admin.users.index', compact('approvedUsers', 'pendingUsers', 'rejectedUsers', 'search'));
    }

    public function approve(User $user)
    {
        $user->update(['status' => 'approved']);

        return redirect()->route('admin.users.index')
            ->with('success', "✅ {$user->name} has been approved and can now log in.");
    }

    public function reject(User $user)
    {
        $user->update(['status' => 'rejected']);

        return redirect()->route('admin.users.index')
            ->with('success', "❌ {$user->name}'s registration has been rejected.");
    }
}

