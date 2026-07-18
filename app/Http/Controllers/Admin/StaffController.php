<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\Store;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $query = Staff::with('store');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('store_id')) {
            $query->where('store_id', $request->store_id);
        }

        $staff    = $query->latest()->paginate(15)->withQueryString();
        $roles    = Staff::$roles;
        $statuses = Staff::$statuses;
        $stores   = Store::orderBy('name')->get();

        return view('admin.staff.index', compact('staff', 'roles', 'statuses', 'stores'));
    }

    public function create()
    {
        $roles    = Staff::$roles;
        $shifts   = Staff::$shifts;
        $statuses = Staff::$statuses;
        $stores   = Store::orderBy('name')->get();

        return view('admin.staff.form', compact('roles', 'shifts', 'statuses', 'stores'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'store_id'       => 'nullable|exists:stores,id',
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:staff,email',
            'phone'          => 'nullable|string|max:30',
            'role'           => 'required|in:barista,cashier,manager,supervisor,cleaner',
            'shift'          => 'required|in:morning,afternoon,evening,full_day',
            'monthly_salary' => 'required|numeric|min:0',
            'join_date'      => 'required|date',
            'status'         => 'required|in:active,on_leave,terminated',
            'photo'          => 'nullable|image|max:2048',
            'notes'          => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('staff', 'public');
        }

        Staff::create($data);

        return redirect()->route('admin.staff.index')
                         ->with('success', '✅ Staff member added successfully!');
    }

    public function show(Staff $staff)
    {
        $staff->load(['store', 'salaryPayments' => fn ($q) => $q->latest('payment_date')->take(12)]);
        return view('admin.staff.show', compact('staff'));
    }

    public function edit(Staff $staff)
    {
        $roles    = Staff::$roles;
        $shifts   = Staff::$shifts;
        $statuses = Staff::$statuses;
        $stores   = Store::orderBy('name')->get();

        return view('admin.staff.form', compact('staff', 'roles', 'shifts', 'statuses', 'stores'));
    }

    public function update(Request $request, Staff $staff)
    {
        $data = $request->validate([
            'store_id'       => 'nullable|exists:stores,id',
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:staff,email,' . $staff->id,
            'phone'          => 'nullable|string|max:30',
            'role'           => 'required|in:barista,cashier,manager,supervisor,cleaner',
            'shift'          => 'required|in:morning,afternoon,evening,full_day',
            'monthly_salary' => 'required|numeric|min:0',
            'join_date'      => 'required|date',
            'status'         => 'required|in:active,on_leave,terminated',
            'photo'          => 'nullable|image|max:2048',
            'notes'          => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('staff', 'public');
        }

        $staff->update($data);

        return redirect()->route('admin.staff.index')
                         ->with('success', '✅ Staff member updated successfully!');
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();
        return redirect()->route('admin.staff.index')
                         ->with('success', '🗑️ Staff member removed.');
    }
}
