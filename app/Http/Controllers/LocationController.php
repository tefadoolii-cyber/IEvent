<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Region;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $query = Location::with('region');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('city', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->has('is_active') && $request->is_active !== '') {
            $query->where('is_active', $request->is_active);
        }
        if ($request->region_id) {
            $query->where('region_id', $request->region_id);
        }

        $locations = $query->latest()->paginate(15)->withQueryString();
        $regions   = Region::where('is_active', true)->orderBy('name')->get();

        return view('locations.index', compact('locations', 'regions'));
    }

    public function create()
    {
        $regions = Region::where('is_active', true)->orderBy('name')->get();
        return view('locations.create', compact('regions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'region_id' => 'nullable|exists:regions,id',
        ]);
        Location::create($request->all());
        return redirect()->route('locations.index')->with('success', 'تم إضافة الموقع بنجاح');
    }

    public function show(Location $location)
    {
        $location->load('region.parent');
        $siblings = $location->region_id
            ? Location::where('region_id', $location->region_id)
                      ->where('id', '!=', $location->id)
                      ->limit(8)->get()
            : collect();

        return view('locations.show', compact('location', 'siblings'));
    }

    public function edit(Location $location)
    {
        $regions = Region::where('is_active', true)->orderBy('name')->get();
        return view('locations.edit', compact('location', 'regions'));
    }

    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'region_id' => 'nullable|exists:regions,id',
        ]);
        $location->update($request->all());
        return redirect()->route('locations.index')->with('success', 'تم تعديل الموقع بنجاح');
    }

    public function destroy(Location $location)
    {
        $location->delete();
        return redirect()->route('locations.index')->with('success', 'تم حذف الموقع');
    }
}
