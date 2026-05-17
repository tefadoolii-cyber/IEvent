<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\JobApplication;
use App\Models\LookupGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JobApplicationController extends Controller
{
    // =================== Public ===================

    public function apply()
    {
        $nationalities    = LookupGroup::where('key', 'nationalities')->first()?->lookups ?? collect();
        $educationLevels  = LookupGroup::where('key', 'education_levels')->first()?->lookups ?? collect();
        return view('apply.form', compact('nationalities', 'educationLevels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name'        => 'required|string|max:255',
            'id_number'        => 'required|string|max:20',
            'phone'            => 'required|string|max:20',
            'email'            => 'nullable|email|max:255',
            'date_of_birth'    => 'nullable|date',
            'nationality'      => 'nullable|string|max:100',
            'address'          => 'nullable|string|max:500',
            'education_level'  => 'nullable|string|max:100',
            'experience_years' => 'nullable|integer|min:0|max:50',
            'desired_position' => 'required|string|max:255',
            'expected_salary'  => 'nullable|numeric|min:0',
            'cover_letter'     => 'nullable|string',
            'photo'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'cv_file'          => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ], [
            'full_name.required' => 'الاسم الكامل مطلوب',
            'id_number.required' => 'رقم الهوية مطلوب',
            'phone.required'     => 'رقم الجوال مطلوب',
            'email.email'        => 'البريد الإلكتروني غير صحيح',
            'photo.image'        => 'يجب أن تكون الصورة بصيغة JPG أو PNG',
            'photo.max'          => 'حجم الصورة يجب أن لا يتجاوز 2 ميجابايت',
            'cv_file.max'          => 'حجم السيرة الذاتية يجب أن لا يتجاوز 5 ميجابايت',
            'desired_position.required' => 'الوظيفة المطلوبة مطلوبة',
        ]);

        $data = $request->except(['photo', 'cv_file']);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('applications/photos', 'public');
        }
        if ($request->hasFile('cv_file')) {
            $data['cv_file'] = $request->file('cv_file')->store('applications/cvs', 'public');
        }

        JobApplication::create($data);

        return redirect()->route('apply.thanks');
    }

    public function thanks()
    {
        return view('apply.thanks');
    }

    // =================== Admin ===================

    public function index(Request $request)
    {
        $query = JobApplication::with('reviewer');

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('full_name', 'like', '%' . $request->search . '%')
                  ->orWhere('id_number', 'like', '%' . $request->search . '%')
                  ->orWhere('desired_position', 'like', '%' . $request->search . '%');
            });
        }

        $applications = $query->latest()->paginate(20)->withQueryString();

        $stats = [
            'total'    => JobApplication::count(),
            'pending'  => JobApplication::where('status', 'pending')->count(),
            'accepted' => JobApplication::where('status', 'accepted')->count(),
            'rejected' => JobApplication::where('status', 'rejected')->count(),
        ];

        return view('job-applications.index', compact('applications', 'stats'));
    }

    public function show(JobApplication $jobApplication)
    {
        $application = $jobApplication;
        return view('job-applications.show', compact('application'));
    }

    public function review(Request $request, JobApplication $jobApplication)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewed,accepted,rejected',
            'notes'  => 'nullable|string',
        ]);

        $jobApplication->update([
            'status'      => $request->status,
            'notes'       => $request->notes,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        return redirect()->back()->with('success', 'تم تحديث حالة المتقدم');
    }

    public function convertForm(JobApplication $jobApplication)
    {
        $application = $jobApplication;
        $departments = LookupGroup::where('key', 'departments')->first()?->lookups ?? collect();
        $jobTitles   = LookupGroup::where('key', 'job_titles')->first()?->lookups ?? collect();
        return view('job-applications.convert', compact('application', 'departments', 'jobTitles'));
    }

    public function doConvert(Request $request, JobApplication $jobApplication)
    {
        $request->validate([
            'employee_number' => 'required|unique:employees,employee_number',
            'department'      => 'nullable|string|max:255',
            'position'        => 'nullable|string|max:255',
            'start_date'      => 'nullable|date',
            'status'          => 'required|in:active,inactive',
        ]);

        $employeeData = [
            'name'            => $jobApplication->full_name,
            'employee_number' => $request->employee_number,
            'phone'           => $jobApplication->phone,
            'email'           => $jobApplication->email,
            'department'      => $request->department,
            'position'        => $request->position ?? $jobApplication->desired_position,
            'start_date'      => $request->start_date,
            'status'          => $request->status,
            'contract_status' => 'active',
        ];

        // Copy files to employees folders
        if ($jobApplication->photo) {
            $dest = 'employees/photos/' . basename($jobApplication->photo);
            Storage::disk('public')->copy($jobApplication->photo, $dest);
            $employeeData['photo'] = $dest;
        }
        if ($jobApplication->cv_file) {
            $dest = 'employees/cvs/' . basename($jobApplication->cv_file);
            Storage::disk('public')->copy($jobApplication->cv_file, $dest);
            $employeeData['cv_file'] = $dest;
        }

        Employee::create($employeeData);

        $jobApplication->update([
            'status'      => 'accepted',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        return redirect()->route('job-applications.index')
            ->with('success', 'تم تحويل المتقدم إلى موظف بنجاح');
    }

    public function destroy(JobApplication $jobApplication)
    {
        if ($jobApplication->photo)   Storage::disk('public')->delete($jobApplication->photo);
        if ($jobApplication->cv_file) Storage::disk('public')->delete($jobApplication->cv_file);
        $jobApplication->delete();
        return redirect()->route('job-applications.index')->with('success', 'تم حذف الطلب');
    }
}
