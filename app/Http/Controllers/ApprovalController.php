<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    public function approve(Request $request)
    {
        $request->validate([
            'model_type' => 'required|string',
            'model_id'   => 'required|integer',
            'reason'     => 'nullable|string',
        ]);

        Approval::updateOrCreate(
            ['model_type' => $request->model_type, 'model_id' => $request->model_id, 'status' => 'approved'],
            [
                'approver_id' => Auth::id(),
                'status'      => 'approved',
                'reason'      => $request->reason,
                'approved_at' => now(),
                'withdrawn_at'=> null,
                'withdrawn_by'=> null,
            ]
        );

        return redirect()->back()->with('success', 'تم الاعتماد بنجاح');
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'model_type' => 'required|string',
            'model_id'   => 'required|integer',
            'reason'     => 'required|string',
        ]);

        $approval = Approval::where('model_type', $request->model_type)
                            ->where('model_id', $request->model_id)
                            ->where('status', 'approved')
                            ->latest()
                            ->first();

        if ($approval) {
            $approval->update([
                'status'       => 'withdrawn',
                'withdrawn_by' => Auth::id(),
                'withdrawn_at' => now(),
                'reason'       => $request->reason,
            ]);
        }

        return redirect()->back()->with('success', 'تم سحب الاعتماد');
    }

    public function index(Request $request)
    {
        $approvals = Approval::with(['approver', 'withdrawer'])
                             ->latest()
                             ->paginate(20)
                             ->withQueryString();

        return view('approvals.index', compact('approvals'));
    }
}
