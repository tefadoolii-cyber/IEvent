<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyQuestion;
use App\Models\SurveyResponse;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    public function index(Request $request)
    {
        $query = Survey::with('creator')->withCount(['questions', 'responses']);

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $surveys = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total'  => Survey::count(),
            'draft'  => Survey::where('status', 'draft')->count(),
            'active' => Survey::where('status', 'active')->count(),
            'closed' => Survey::where('status', 'closed')->count(),
        ];

        return view('surveys.index', compact('surveys', 'stats'));
    }

    public function create()
    {
        return view('surveys.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:draft,active,closed',
            'starts_at'   => 'nullable|date',
            'ends_at'     => 'nullable|date|after_or_equal:starts_at',
            'questions'   => 'nullable|array',
            'questions.*.question' => 'required|string|max:500',
            'questions.*.type'     => 'required|in:text,rating,single_choice,multiple_choice',
        ]);

        $survey = Survey::create([
            'title'       => $request->title,
            'description' => $request->description,
            'status'      => $request->status,
            'created_by'  => Auth::id(),
            'starts_at'   => $request->starts_at,
            'ends_at'     => $request->ends_at,
        ]);

        foreach ($request->input('questions', []) as $i => $q) {
            $options = [];
            if (in_array($q['type'], ['single_choice', 'multiple_choice'])) {
                $options = array_filter(explode("\n", $q['options'] ?? ''), fn($o) => trim($o) !== '');
                $options = array_values($options);
            }
            $survey->questions()->create([
                'question' => $q['question'],
                'type'     => $q['type'],
                'options'  => $options ?: null,
                'required' => isset($q['required']),
                'order'    => $i,
            ]);
        }

        return redirect()->route('surveys.show', $survey)->with('success', 'تم إنشاء الاستبيان بنجاح');
    }

    public function show(Survey $survey)
    {
        $survey->load(['creator', 'questions', 'responses.employee']);
        return view('surveys.show', compact('survey'));
    }

    public function edit(Survey $survey)
    {
        $survey->load('questions');
        return view('surveys.edit', compact('survey'));
    }

    public function update(Request $request, Survey $survey)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:draft,active,closed',
            'starts_at'   => 'nullable|date',
            'ends_at'     => 'nullable|date|after_or_equal:starts_at',
        ]);

        $survey->update($request->only(['title', 'description', 'status', 'starts_at', 'ends_at']));

        return redirect()->route('surveys.show', $survey)->with('success', 'تم تعديل الاستبيان');
    }

    public function destroy(Survey $survey)
    {
        $survey->delete();
        return redirect()->route('surveys.index')->with('success', 'تم حذف الاستبيان');
    }

    public function addQuestion(Request $request, Survey $survey)
    {
        $request->validate([
            'question' => 'required|string|max:500',
            'type'     => 'required|in:text,rating,single_choice,multiple_choice',
            'required' => 'nullable|boolean',
            'options'  => 'nullable|string',
        ]);

        $options = [];
        if (in_array($request->type, ['single_choice', 'multiple_choice'])) {
            $options = array_filter(explode("\n", $request->options ?? ''), fn($o) => trim($o) !== '');
            $options = array_values($options);
        }

        $survey->questions()->create([
            'question' => $request->question,
            'type'     => $request->type,
            'options'  => $options ?: null,
            'required' => $request->boolean('required'),
            'order'    => $survey->questions()->max('order') + 1,
        ]);

        return redirect()->back()->with('success', 'تمت إضافة السؤال');
    }

    public function removeQuestion(Survey $survey, SurveyQuestion $question)
    {
        $question->delete();
        return redirect()->back()->with('success', 'تم حذف السؤال');
    }

    public function respond(Request $request, Survey $survey)
    {
        $employee = Auth::user()->employee;
        if (!$employee) return redirect()->back()->with('error', 'لا يوجد ربط بموظف');

        if ($survey->status !== 'active') {
            return redirect()->back()->with('error', 'الاستبيان غير متاح للإجابة');
        }

        if (SurveyResponse::where('survey_id', $survey->id)->where('employee_id', $employee->id)->exists()) {
            return redirect()->back()->with('error', 'لقد أجبت على هذا الاستبيان مسبقاً');
        }

        SurveyResponse::create([
            'survey_id'   => $survey->id,
            'employee_id' => $employee->id,
            'answers'     => $request->input('answers', []),
        ]);

        return redirect()->back()->with('success', 'شكراً، تم تسجيل إجابتك');
    }
}
