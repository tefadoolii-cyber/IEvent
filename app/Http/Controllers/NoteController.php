<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\LookupGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'model_type' => 'required|string',
            'model_id'   => 'required|integer',
            'note'       => 'required|string',
            'severity'   => 'required|in:info,warning,critical',
            'type_id'    => 'nullable|exists:lookups,id',
        ]);

        Note::create(array_merge($request->all(), ['created_by' => Auth::id()]));

        return redirect()->back()->with('success', 'تمت إضافة الملاحظة');
    }

    public function destroy(Note $note)
    {
        $note->delete();
        return redirect()->back()->with('success', 'تم حذف الملاحظة');
    }

    public function index(Request $request)
    {
        $query = Note::with(['creator', 'noteType']);

        if ($request->model_type) {
            $query->where('model_type', $request->model_type);
        }
        if ($request->severity) {
            $query->where('severity', $request->severity);
        }

        $notes     = $query->latest()->paginate(20)->withQueryString();
        $noteTypes = LookupGroup::where('key', 'note_types')->first()?->lookups ?? collect();

        return view('notes.index', compact('notes', 'noteTypes'));
    }
}
