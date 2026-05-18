<?php

namespace App\Http\Controllers;

use App\Models\JobOpening;
use Illuminate\Http\Request;

class JobOpeningController extends Controller
{
    public function index()
    {
        $openings = JobOpening::withCount('applications')->latest()->paginate(15);
        return view('job-openings.index', compact('openings'));
    }

    public function create()
    {
        $availableFields = JobOpening::$availableFields;
        return view('job-openings.create', compact('availableFields'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'department'     => 'nullable|string|max:255',
            'description'    => 'nullable|string',
            'deadline'       => 'nullable|date',
            'max_applicants' => 'nullable|integer|min:1',
            'fields'         => 'nullable|array',
        ]);

        $fields = $this->buildFields($request);

        JobOpening::create([
            'title'          => $request->title,
            'department'     => $request->department,
            'description'    => $request->description,
            'deadline'       => $request->deadline,
            'max_applicants' => $request->max_applicants,
            'is_active'      => $request->boolean('is_active', true),
            'fields'         => $fields,
        ]);

        return redirect()->route('job-openings.index')->with('success', 'تم إنشاء الوظيفة بنجاح');
    }

    public function edit(JobOpening $jobOpening)
    {
        $availableFields = JobOpening::$availableFields;
        return view('job-openings.edit', compact('jobOpening', 'availableFields'));
    }

    public function update(Request $request, JobOpening $jobOpening)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'department'     => 'nullable|string|max:255',
            'description'    => 'nullable|string',
            'deadline'       => 'nullable|date',
            'max_applicants' => 'nullable|integer|min:1',
        ]);

        $fields = $this->buildFields($request);

        $jobOpening->update([
            'title'          => $request->title,
            'department'     => $request->department,
            'description'    => $request->description,
            'deadline'       => $request->deadline,
            'max_applicants' => $request->max_applicants,
            'is_active'      => $request->boolean('is_active'),
            'fields'         => $fields,
        ]);

        return redirect()->route('job-openings.index')->with('success', 'تم تحديث الوظيفة بنجاح');
    }

    public function destroy(JobOpening $jobOpening)
    {
        $jobOpening->delete();
        return redirect()->route('job-openings.index')->with('success', 'تم حذف الوظيفة');
    }

    private function buildFields(Request $request): array
    {
        $enabled  = $request->input('field_enabled', []);
        $required = $request->input('field_required', []);
        $fields   = [];

        foreach (JobOpening::$availableFields as $key => $def) {
            if (in_array($key, $enabled)) {
                $fields[] = [
                    'key'      => $key,
                    'required' => in_array($key, $required),
                ];
            }
        }

        return $fields;
    }
}
