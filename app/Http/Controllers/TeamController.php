<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Employee;
use App\Models\Region;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $query = Team::with(['supervisor', 'region'])->withCount('members');
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $teams = $query->latest()->paginate(15)->withQueryString();
        return view('teams.index', compact('teams'));
    }

    public function create()
    {
        $employees = Employee::where('status', 'active')->get();
        $regions   = Region::where('is_active', true)->get();
        return view('teams.create', compact('employees', 'regions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'supervisor_id' => 'nullable|exists:employees,id',
            'region_id'     => 'nullable|exists:regions,id',
            'notes'         => 'nullable|string',
        ]);
        Team::create($request->all());
        return redirect()->route('teams.index')->with('success', 'تم إنشاء الفريق');
    }

    public function show(Team $team)
    {
        $team->load(['supervisor', 'region', 'members']);
        $allEmployees = Employee::where('status', 'active')
                                ->whereNotIn('id', $team->members->pluck('id'))
                                ->get();
        return view('teams.show', compact('team', 'allEmployees'));
    }

    public function edit(Team $team)
    {
        $employees = Employee::where('status', 'active')->get();
        $regions   = Region::where('is_active', true)->get();
        return view('teams.edit', compact('team', 'employees', 'regions'));
    }

    public function update(Request $request, Team $team)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'supervisor_id' => 'nullable|exists:employees,id',
            'region_id'     => 'nullable|exists:regions,id',
            'notes'         => 'nullable|string',
        ]);
        $team->update($request->all());
        return redirect()->route('teams.index')->with('success', 'تم تعديل الفريق');
    }

    public function destroy(Team $team)
    {
        $team->delete();
        return redirect()->route('teams.index')->with('success', 'تم حذف الفريق');
    }

    public function addMember(Request $request, Team $team)
    {
        $request->validate(['employee_id' => 'required|exists:employees,id']);
        $team->members()->syncWithoutDetaching([$request->employee_id]);
        return redirect()->back()->with('success', 'تم إضافة العضو للفريق');
    }

    public function removeMember(Team $team, Employee $employee)
    {
        $team->members()->detach($employee->id);
        return redirect()->back()->with('success', 'تم إزالة العضو من الفريق');
    }
}
