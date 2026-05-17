<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index(Request $request)
    {
        $query = Region::with('parent')->withCount('locations');
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $regions = $query->latest()->paginate(20)->withQueryString();
        $parents = Region::whereNull('parent_id')->get();
        return view('regions.index', compact('regions', 'parents'));
    }

    public function show(Region $region)
    {
        $region->load(['parent', 'children', 'locations']);
        return view('regions.show', compact('region'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'parent_id' => 'nullable|exists:regions,id',
            'notes'     => 'nullable|string',
        ]);
        Region::create($request->all());
        return redirect()->route('regions.index')->with('success', 'تم إضافة المنطقة');
    }

    public function update(Request $request, Region $region)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'parent_id' => 'nullable|exists:regions,id',
            'notes'     => 'nullable|string',
        ]);
        $region->update($request->all());
        return redirect()->route('regions.index')->with('success', 'تم تعديل المنطقة');
    }

    public function destroy(Region $region)
    {
        $region->delete();
        return redirect()->route('regions.index')->with('success', 'تم حذف المنطقة');
    }
}
