<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalaryPayment;
use App\Models\Staff;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function index(Request $request)
    {
        $query = SalaryPayment::with('staff')->latest('payment_date');

        if ($request->filled('staff_id')) {
            $query->where('staff_id', $request->staff_id);
        }
        if ($request->filled('month')) {
            $query->where('payment_month', $request->month);
        }

        $payments    = $query->paginate(20)->withQueryString();
        $staffList   = Staff::orderBy('name')->get();
        $methods     = SalaryPayment::$methods;

        return view('admin.salaries.index', compact('payments', 'staffList', 'methods'));
    }

    public function pending()
    {
        $currentMonth = now()->format('Y-m');

        $pendingStaff = Staff::where('status', 'active')
            ->whereDoesntHave('salaryPayments', function ($q) use ($currentMonth) {
                $q->where('payment_month', $currentMonth);
            })
            ->with('store')
            ->orderBy('name')
            ->get();

        return view('admin.salaries.pending', compact('pendingStaff', 'currentMonth'));
    }

    public function create(Request $request)
    {
        $staffList    = Staff::where('status', 'active')->orderBy('name')->get();
        $methods      = SalaryPayment::$methods;
        $currentMonth = now()->format('Y-m');
        $selectedStaff = $request->filled('staff_id')
            ? Staff::find($request->staff_id)
            : null;

        return view('admin.salaries.create', compact('staffList', 'methods', 'currentMonth', 'selectedStaff'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'staff_id'       => 'required|exists:staff,id',
            'amount'         => 'required|numeric|min:0',
            'payment_month'  => 'required|date_format:Y-m',
            'payment_date'   => 'required|date',
            'payment_method' => 'required|in:cash,bank_transfer,mobile_banking',
            'note'           => 'nullable|string',
        ]);

        // Duplicate guard
        $exists = SalaryPayment::where('staff_id', $data['staff_id'])
            ->where('payment_month', $data['payment_month'])
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'payment_month' => 'Salary for this month has already been recorded for this staff member.',
            ]);
        }

        $data['paid_by'] = auth()->user()->name;

        SalaryPayment::create($data);

        return redirect()->route('admin.salaries.index')
                         ->with('success', '✅ Salary payment recorded successfully!');
    }

    public function destroy(SalaryPayment $payment)
    {
        $payment->delete();
        return back()->with('success', '🗑️ Payment record deleted.');
    }
}
