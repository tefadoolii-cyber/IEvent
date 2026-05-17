<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with('employee');

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhereHas('employee', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
        }
        if ($request->status)   $query->where('status', $request->status);
        if ($request->priority) $query->where('priority', $request->priority);
        if ($request->employee_id) $query->where('employee_id', $request->employee_id);

        $tasks     = $query->latest()->paginate(15)->withQueryString();
        $employees = Employee::where('status', 'active')->get();
        return view('tasks.index', compact('tasks', 'employees'));
    }

    public function create()
    {
        $employees = Employee::where('status', 'active')->get();
        return view('tasks.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'employee_id' => 'required|exists:employees,id',
            'status'      => 'required|in:new,in_progress,completed,cancelled',
            'priority'    => 'required|in:low,medium,high,urgent',
            'due_date'    => 'nullable|date',
        ]);

        $data = $request->all();
        $data['assigned_by'] = Auth::id();
        if ($data['status'] === 'completed') {
            $data['completed_at'] = now();
        }

        Task::create($data);
        return redirect()->route('tasks.index')->with('success', 'تم إضافة المهمة بنجاح');
    }

    public function edit(Task $task)
    {
        $employees = Employee::where('status', 'active')->get();
        return view('tasks.edit', compact('task', 'employees'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'employee_id' => 'required|exists:employees,id',
            'status'      => 'required|in:new,in_progress,completed,cancelled',
            'priority'    => 'required|in:low,medium,high,urgent',
            'due_date'    => 'nullable|date',
        ]);

        $data = $request->all();
        if ($data['status'] === 'completed' && !$task->completed_at) {
            $data['completed_at'] = now();
        }

        $task->update($data);
        return redirect()->route('tasks.index')->with('success', 'تم تعديل المهمة بنجاح');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'تم حذف المهمة');
    }
}
