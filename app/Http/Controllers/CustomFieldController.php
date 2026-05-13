<?php

namespace App\Http\Controllers;

use App\Models\CustomField;
use Illuminate\Http\Request;

class CustomFieldController extends Controller
{
    public function index()
    {
        $fields = CustomField::orderBy('table_name')->orderBy('order')->get()->groupBy('table_name');
        return view('custom_fields.index', compact('fields'));
    }

    public function create()
    {
        return view('custom_fields.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'table_name'  => 'required',
            'field_key'   => 'required',
            'field_label' => 'required',
            'field_type'  => 'required',
        ]);

        CustomField::create([
            'table_name'  => $request->table_name,
            'field_key'   => $request->field_key,
            'field_label' => $request->field_label,
            'field_type'  => $request->field_type,
            'options'     => $request->options,
            'is_required' => $request->is_required ? true : false,
            'order'       => $request->order ?? 0,
        ]);

        return redirect()->route('custom-fields.index')->with('success', 'تم إضافة الحقل بنجاح');
    }

    public function edit(CustomField $customField)
    {
        return view('custom_fields.edit', compact('customField'));
    }

    public function update(Request $request, CustomField $customField)
    {
        $request->validate([
            'table_name'  => 'required',
            'field_key'   => 'required',
            'field_label' => 'required',
            'field_type'  => 'required',
        ]);

        $customField->update([
            'table_name'  => $request->table_name,
            'field_key'   => $request->field_key,
            'field_label' => $request->field_label,
            'field_type'  => $request->field_type,
            'options'     => $request->options,
            'is_required' => $request->is_required ? true : false,
            'order'       => $request->order ?? 0,
        ]);

        return redirect()->route('custom-fields.index')->with('success', 'تم تعديل الحقل بنجاح');
    }

    public function destroy(CustomField $customField)
    {
        $customField->delete();
        return redirect()->route('custom-fields.index')->with('success', 'تم حذف الحقل');
    }
}
