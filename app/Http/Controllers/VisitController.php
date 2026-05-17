<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Employee;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitController extends Controller
{
    public function index(Request $request)
    {
        $query = Visit::with(['employee', 'location']);

        if ($request->search) {
            $query->whereHas('employee', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->date) {
            $query->whereDate('visit_date', $request->date);
        }

        $visits = $query->latest('visit_date')->paginate(20)->withQueryString();
        return view('visits.index', compact('visits'));
    }

    public function create()
    {
        $employees = Employee::where('status', 'active')->get();
        $locations = Location::where('is_active', true)->get();
        return view('visits.create', compact('employees', 'locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id'    => 'required|exists:employees,id',
            'location_id'    => 'nullable|exists:locations,id',
            'visit_date'     => 'required|date',
            'check_in_time'  => 'nullable',
            'check_out_time' => 'nullable',
            'notes'          => 'nullable|string',
            'status'         => 'required|in:pending,completed,cancelled',
        ]);
        Visit::create($request->all());
        return redirect()->route('visits.index')->with('success', 'تم تسجيل الزيارة');
    }

    public function show(Visit $visit)
    {
        $visit->load(['employee', 'location']);
        return view('visits.show', compact('visit'));
    }

    public function edit(Visit $visit)
    {
        $employees = Employee::where('status', 'active')->get();
        $locations = Location::where('is_active', true)->get();
        return view('visits.edit', compact('visit', 'employees', 'locations'));
    }

    public function update(Request $request, Visit $visit)
    {
        $request->validate([
            'employee_id'    => 'required|exists:employees,id',
            'location_id'    => 'nullable|exists:locations,id',
            'visit_date'     => 'required|date',
            'check_in_time'  => 'nullable',
            'check_out_time' => 'nullable',
            'notes'          => 'nullable|string',
            'status'         => 'required|in:pending,completed,cancelled',
        ]);
        $visit->update($request->all());
        return redirect()->route('visits.index')->with('success', 'تم تعديل الزيارة');
    }

    public function destroy(Visit $visit)
    {
        $visit->delete();
        return redirect()->route('visits.index')->with('success', 'تم حذف الزيارة');
    }

    // portal: employee registers own visit
    public function portalStore(Request $request)
    {
        $user     = Auth::user();
        $employee = $user->employee;

        if (!$employee) {
            return redirect()->back()->with('error', 'لا يوجد ربط بملف موظف');
        }

        $request->validate([
            'location_id' => 'nullable|exists:locations,id',
            'visit_date'  => 'required|date',
            'notes'       => 'nullable|string',
            'lat'         => 'nullable|numeric',
            'lng'         => 'nullable|numeric',
        ]);

        Visit::create([
            'employee_id'   => $employee->id,
            'location_id'   => $request->location_id,
            'visit_date'    => $request->visit_date,
            'check_in_time' => now()->format('H:i:s'),
            'lat'           => $request->lat,
            'lng'           => $request->lng,
            'notes'         => $request->notes,
            'status'        => 'pending',
        ]);

        return redirect()->back()->with('success', 'تم تسجيل الزيارة بنجاح');
    }
}
