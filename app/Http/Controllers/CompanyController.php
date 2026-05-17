<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $query = Company::query();
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('city', 'like', '%' . $request->search . '%');
        }
        if ($request->has('is_active') && $request->is_active !== '') {
            $query->where('is_active', $request->is_active);
        }
        $companies = $query->latest()->paginate(15)->withQueryString();
        return view('companies.index', compact('companies'));
    }

    public function create() { return view('companies.create'); }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Company::create($request->all());
        return redirect()->route('companies.index')->with('success', 'تم إضافة الشركة بنجاح');
    }

    public function edit(Company $company) { return view('companies.edit', compact('company')); }

    public function update(Request $request, Company $company)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $company->update($request->all());
        return redirect()->route('companies.index')->with('success', 'تم تعديل الشركة بنجاح');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('companies.index')->with('success', 'تم حذف الشركة');
    }
}
