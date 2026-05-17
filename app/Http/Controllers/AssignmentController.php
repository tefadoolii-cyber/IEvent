<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Employee;
use App\Models\Location;
use App\Models\Company;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Assignment::with(['employee', 'location.region', 'company', 'supervisor']);

        if ($request->search) {
            $query->whereHas('employee', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
        }
        if ($request->status)      $query->where('status', $request->status);
        if ($request->location_id) $query->where('location_id', $request->location_id);
        if ($request->company_id)  $query->where('company_id', $request->company_id);

        $assignments = $query->latest()->paginate(15)->withQueryString();
        $locations   = Location::with('region')->where('is_active', true)->orderBy('name')->get();
        $companies   = Company::where('is_active', true)->get();
        return view('assignments.index', compact('assignments', 'locations', 'companies'));
    }

    public function create()
    {
        $employees = Employee::where('status', 'active')->get();
        $locations = Location::with('region')->where('is_active', true)->orderBy('name')->get();
        $companies = Company::where('is_active', true)->get();
        return view('assignments.create', compact('employees', 'locations', 'companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date|after:start_date',
            'status'      => 'required|in:active,completed,cancelled',
        ]);

        Assignment::create($request->all());
        return redirect()->route('assignments.index')->with('success', 'تم إضافة الإسناد بنجاح');
    }

    public function show(Assignment $assignment)
    {
        $assignment->load(['employee', 'location.region', 'company', 'supervisor']);
        return view('assignments.show', compact('assignment'));
    }

    public function edit(Assignment $assignment)
    {
        $employees = Employee::where('status', 'active')->get();
        $locations = Location::with('region')->where('is_active', true)->orderBy('name')->get();
        $companies = Company::where('is_active', true)->get();
        return view('assignments.edit', compact('assignment', 'employees', 'locations', 'companies'));
    }

    public function update(Request $request, Assignment $assignment)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date|after:start_date',
            'status'      => 'required|in:active,completed,cancelled',
        ]);

        $assignment->update($request->all());
        return redirect()->route('assignments.index')->with('success', 'تم تعديل الإسناد بنجاح');
    }

    public function destroy(Assignment $assignment)
    {
        $assignment->delete();
        return redirect()->route('assignments.index')->with('success', 'تم حذف الإسناد');
    }
}
