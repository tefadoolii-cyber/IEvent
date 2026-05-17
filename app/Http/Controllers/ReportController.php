<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Contract;
use App\Models\Evaluation;
use App\Models\Task;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendanceReportExport;
use App\Exports\ContractsReportExport;
use App\Exports\EvaluationsReportExport;
use App\Exports\TasksReportExport;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function attendance(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        [$year, $mon] = explode('-', $month);

        $data = Attendance::with('employee')
            ->whereYear('date', $year)
            ->whereMonth('date', $mon)
            ->get()
            ->groupBy('employee_id');

        $summary = $data->map(function ($records) {
            return [
                'employee' => $records->first()->employee,
                'present'  => $records->where('status', 'present')->count(),
                'absent'   => $records->where('status', 'absent')->count(),
                'late'     => $records->where('status', 'late')->count(),
                'total'    => $records->count(),
            ];
        })->values();

        if ($request->export === 'excel') {
            return Excel::download(new AttendanceReportExport($summary, $month), "attendance_{$month}.xlsx");
        }

        $chartData = Attendance::whereYear('date', $year)
            ->whereMonth('date', $mon)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('reports.attendance', compact('summary', 'month', 'chartData'));
    }

    public function contracts(Request $request)
    {
        $status  = $request->input('status', '');
        $query   = Contract::with('employee');
        if ($status) $query->where('status', $status);
        $contracts = $query->latest()->get();

        if ($request->export === 'excel') {
            return Excel::download(new ContractsReportExport($contracts), 'contracts_report.xlsx');
        }

        $statusCounts = Contract::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')->pluck('count', 'status');

        return view('reports.contracts', compact('contracts', 'status', 'statusCounts'));
    }

    public function evaluations(Request $request)
    {
        $period = $request->input('period', '');
        $query  = Evaluation::with('employee');
        if ($period) $query->where('period', $period);
        $evaluations = $query->latest()->get();

        if ($request->export === 'excel') {
            return Excel::download(new EvaluationsReportExport($evaluations), 'evaluations_report.xlsx');
        }

        $avgScore = $evaluations->avg('total_score');
        $periods  = Evaluation::distinct()->pluck('period');

        return view('reports.evaluations', compact('evaluations', 'period', 'avgScore', 'periods'));
    }

    public function tasks(Request $request)
    {
        $status = $request->input('status', '');
        $query  = Task::with('employee');
        if ($status) $query->where('status', $status);
        $tasks = $query->latest()->get();

        if ($request->export === 'excel') {
            return Excel::download(new TasksReportExport($tasks), 'tasks_report.xlsx');
        }

        $statusCounts = Task::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')->pluck('count', 'status');

        return view('reports.tasks', compact('tasks', 'status', 'statusCounts'));
    }
}
