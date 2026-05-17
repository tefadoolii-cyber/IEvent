<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetAssignment;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $query = Asset::withCount('assignments');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('serial_number', 'like', '%' . $request->search . '%');
        }
        if ($request->status) $query->where('status', $request->status);
        if ($request->type)   $query->where('type', $request->type);

        $assets = $query->latest()->paginate(15)->withQueryString();
        return view('assets.index', compact('assets'));
    }

    public function create()
    {
        return view('assets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'serial_number' => 'nullable|unique:assets,serial_number',
            'status'        => 'required|in:available,assigned,maintenance,retired',
        ]);

        Asset::create($request->all());
        return redirect()->route('assets.index')->with('success', 'تم إضافة الجهاز بنجاح');
    }

    public function show(Asset $asset)
    {
        $asset->load(['assignments.employee', 'assignments.assignedBy']);
        $employees = Employee::where('status', 'active')->get();
        return view('assets.show', compact('asset', 'employees'));
    }

    public function edit(Asset $asset)
    {
        return view('assets.edit', compact('asset'));
    }

    public function update(Request $request, Asset $asset)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'serial_number' => 'nullable|unique:assets,serial_number,' . $asset->id,
            'status'        => 'required|in:available,assigned,maintenance,retired',
        ]);

        $asset->update($request->all());
        return redirect()->route('assets.index')->with('success', 'تم تعديل الجهاز بنجاح');
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();
        return redirect()->route('assets.index')->with('success', 'تم حذف الجهاز');
    }

    public function assign(Request $request, Asset $asset)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
        ]);

        if ($asset->status === 'assigned') {
            return redirect()->back()->with('error', 'الجهاز مُسلَّم لموظف آخر بالفعل');
        }

        AssetAssignment::create([
            'asset_id'     => $asset->id,
            'employee_id'  => $request->employee_id,
            'assigned_by'  => Auth::id(),
            'delivered_at' => now(),
            'notes'        => $request->notes,
        ]);

        $asset->update(['status' => 'assigned']);
        return redirect()->back()->with('success', 'تم تسليم الجهاز للموظف بنجاح');
    }

    public function returnAsset(Request $request, AssetAssignment $assignment)
    {
        $assignment->update(['returned_at' => now()]);
        $assignment->asset->update(['status' => 'available']);
        return redirect()->back()->with('success', 'تم استلام الجهاز بنجاح');
    }
}
