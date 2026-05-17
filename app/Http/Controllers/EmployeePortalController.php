<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Contract;
use App\Models\Task;
use App\Models\SupportTicket;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeePortalController extends Controller
{
    private function getEmployee(): ?Employee
    {
        return Auth::user()->employee;
    }

    public function dashboard()
    {
        $employee = $this->getEmployee();
        $today    = now()->toDateString();

        $todayAttendance = $employee
            ? Attendance::where('employee_id', $employee->id)->whereDate('date', $today)->first()
            : null;

        $monthAttendance = $employee
            ? Attendance::where('employee_id', $employee->id)->whereMonth('date', now()->month)->get()
            : collect();

        $stats = [
            'present'    => $monthAttendance->where('status', 'present')->count(),
            'absent'     => $monthAttendance->where('status', 'absent')->count(),
            'late'       => $monthAttendance->where('status', 'late')->count(),
            'total_days' => $monthAttendance->count(),
        ];

        $pendingTasks = $employee
            ? Task::where('employee_id', $employee->id)->whereIn('status', ['new', 'in_progress'])->count()
            : 0;

        $activeAssets = $employee
            ? $employee->activeAssets()->count()
            : 0;

        return view('employee.dashboard', compact('employee', 'todayAttendance', 'stats', 'pendingTasks', 'activeAssets'));
    }

    public function checkIn(Request $request)
    {
        $employee = $this->getEmployee();
        if (!$employee) return redirect()->back()->with('error', 'لا يوجد ربط بالموظف');

        $today    = now()->toDateString();
        $existing = Attendance::where('employee_id', $employee->id)->whereDate('date', $today)->first();

        if ($existing) {
            return redirect()->back()->with('error', 'تم تسجيل الحضور مسبقاً');
        }

        Attendance::create([
            'employee_id' => $employee->id,
            'date'        => $today,
            'check_in'    => now()->format('H:i:s'),
            'status'      => 'present',
        ]);

        return redirect()->back()->with('success', 'تم تسجيل الحضور بنجاح');
    }

    public function checkOut(Request $request)
    {
        $employee = $this->getEmployee();
        if (!$employee) return redirect()->back()->with('error', 'لا يوجد ربط بالموظف');

        $attendance = Attendance::where('employee_id', $employee->id)->whereDate('date', today())->first();

        if (!$attendance) {
            return redirect()->back()->with('error', 'لم يتم تسجيل الحضور بعد');
        }

        $attendance->update(['check_out' => now()->format('H:i:s')]);
        return redirect()->back()->with('success', 'تم تسجيل الانصراف بنجاح');
    }

    public function profile()
    {
        $employee = $this->getEmployee();
        return view('employee.profile', compact('employee'));
    }

    public function updateProfile(Request $request)
    {
        $employee = $this->getEmployee();
        if (!$employee) return redirect()->back()->with('error', 'لا يوجد ربط بالموظف');

        $request->validate([
            'photo'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('photo')) {
            if ($employee->photo) \Illuminate\Support\Facades\Storage::disk('public')->delete($employee->photo);
            $employee->photo = $request->file('photo')->store('employees/photos', 'public');
        }
        if ($request->hasFile('cv_file')) {
            if ($employee->cv_file) \Illuminate\Support\Facades\Storage::disk('public')->delete($employee->cv_file);
            $employee->cv_file = $request->file('cv_file')->store('employees/cvs', 'public');
        }
        $employee->save();

        return redirect()->back()->with('success', 'تم تحديث ملفك الشخصي بنجاح');
    }

    // =================== العقود ===================

    public function contracts()
    {
        $employee  = $this->getEmployee();
        $contracts = $employee
            ? Contract::where('employee_id', $employee->id)->latest()->get()
            : collect();

        return view('employee.contracts', compact('employee', 'contracts'));
    }

    public function signContract(Request $request, Contract $contract)
    {
        $employee = $this->getEmployee();

        if (!$employee || $contract->employee_id !== $employee->id) {
            abort(403);
        }

        $request->validate(['signature' => 'required|string']);

        if ($contract->status === 'cancelled') {
            return redirect()->back()->with('error', 'لا يمكن توقيع عقد ملغي');
        }

        $contract->update([
            'signature' => $request->signature,
            'signed_at' => now(),
            'status'    => 'signed',
        ]);

        return redirect()->back()->with('success', 'تم توقيع العقد بنجاح');
    }

    // =================== المهام ===================

    public function tasks()
    {
        $employee = $this->getEmployee();
        $tasks    = $employee
            ? Task::where('employee_id', $employee->id)->latest()->get()
            : collect();

        return view('employee.tasks', compact('employee', 'tasks'));
    }

    public function updateTaskStatus(Request $request, Task $task)
    {
        $employee = $this->getEmployee();

        if (!$employee || $task->employee_id !== $employee->id) {
            abort(403);
        }

        $request->validate(['status' => 'required|in:new,in_progress,completed']);

        $data = ['status' => $request->status];
        if ($request->status === 'completed' && !$task->completed_at) {
            $data['completed_at'] = now();
        }

        $task->update($data);
        return redirect()->back()->with('success', 'تم تحديث حالة المهمة');
    }

    // =================== العهد ===================

    public function assets()
    {
        $employee    = $this->getEmployee();
        $assignments = $employee
            ? $employee->assetAssignments()->with('asset')->latest()->get()
            : collect();

        return view('employee.assets', compact('employee', 'assignments'));
    }

    // =================== الزيارات ===================

    public function visits()
    {
        $employee = $this->getEmployee();
        $visits   = $employee
            ? Visit::where('employee_id', $employee->id)->with('location')->latest()->paginate(15)
            : collect();

        $locations = \App\Models\Location::orderBy('name')->get();

        return view('employee.visits', compact('employee', 'visits', 'locations'));
    }

    // =================== الدعم الفني ===================

    public function support()
    {
        $tickets = SupportTicket::where('user_id', Auth::id())->latest()->get();
        return view('employee.support', compact('tickets'));
    }

    public function createTicket(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'priority'    => 'required|in:low,medium,high,urgent',
        ]);

        SupportTicket::create([
            'user_id'     => Auth::id(),
            'title'       => $request->title,
            'description' => $request->description,
            'priority'    => $request->priority,
            'status'      => 'open',
        ]);

        return redirect()->back()->with('success', 'تم إرسال طلب الدعم بنجاح');
    }
}
