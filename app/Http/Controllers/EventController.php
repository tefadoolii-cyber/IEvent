<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Employee;
use App\Models\Location;
use App\Models\User;
use App\Models\LookupGroup;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with(['location', 'manager']);

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->type) {
            $query->where('type', $request->type);
        }

        $events = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total'     => Event::count(),
            'planning'  => Event::where('status', 'planning')->count(),
            'active'    => Event::where('status', 'active')->count(),
            'completed' => Event::where('status', 'completed')->count(),
        ];

        $eventTypes = LookupGroup::where('key', 'event_types')->first()?->lookups ?? collect();

        return view('events.index', compact('events', 'stats', 'eventTypes'));
    }

    public function create()
    {
        $locations  = Location::where('is_active', true)->get();
        $managers   = User::all();
        $eventTypes = LookupGroup::where('key', 'event_types')->first()?->lookups ?? collect();
        return view('events.create', compact('locations', 'managers', 'eventTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'nullable|string|max:100',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'location_id' => 'nullable|exists:locations,id',
            'status'      => 'required|in:planning,active,completed,cancelled',
            'description' => 'nullable|string',
            'budget'      => 'nullable|numeric|min:0',
            'manager_id'  => 'nullable|exists:users,id',
        ]);

        Event::create($request->all());

        return redirect()->route('events.index')->with('success', 'تم إضافة الحدث بنجاح');
    }

    public function show(Event $event)
    {
        $event->load(['location', 'manager', 'employees']);

        $stats = [
            'employees' => $event->employees->count(),
            'duration'  => $event->start_date && $event->end_date
                           ? $event->start_date->diffInDays($event->end_date) + 1
                           : 1,
        ];

        $allEmployees = Employee::where('status', 'active')
                                ->whereNotIn('id', $event->employees->pluck('id'))
                                ->get();

        return view('events.show', compact('event', 'stats', 'allEmployees'));
    }

    public function edit(Event $event)
    {
        $locations  = Location::where('is_active', true)->get();
        $managers   = User::all();
        $eventTypes = LookupGroup::where('key', 'event_types')->first()?->lookups ?? collect();
        return view('events.edit', compact('event', 'locations', 'managers', 'eventTypes'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'nullable|string|max:100',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'location_id' => 'nullable|exists:locations,id',
            'status'      => 'required|in:planning,active,completed,cancelled',
            'description' => 'nullable|string',
            'budget'      => 'nullable|numeric|min:0',
            'manager_id'  => 'nullable|exists:users,id',
        ]);

        $event->update($request->all());

        return redirect()->route('events.index')->with('success', 'تم تعديل الحدث بنجاح');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('success', 'تم حذف الحدث');
    }

    public function addEmployee(Request $request, Event $event)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'role'        => 'nullable|string|max:100',
        ]);

        $event->employees()->syncWithoutDetaching([
            $request->employee_id => ['role' => $request->role],
        ]);

        return redirect()->back()->with('success', 'تم إضافة الموظف للحدث');
    }

    public function removeEmployee(Event $event, Employee $employee)
    {
        $event->employees()->detach($employee->id);
        return redirect()->back()->with('success', 'تم إزالة الموظف من الحدث');
    }
}
