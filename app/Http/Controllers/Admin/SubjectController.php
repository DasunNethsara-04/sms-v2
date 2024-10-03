<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        return view('pages.admin.subject.add');
    }

    public function showAllSubjects()
    {
        $subjects = Subject::get();
        return view('pages.admin.subject.index', ['subjects' => $subjects]);
    }

    public function store(Request $request)
    {
        // validate the request
        $request->validate([
            'name' => ['required', 'string', 'min:3'],
            'code' => ['required', 'string', 'min:2'],
            'description' => ['nullable', 'string'],
        ]);

        // create a new subject
        Subject::create([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
        ]);

        return redirect('/admin/subjects/show')->with('success', 'Subject added successfully');
    }

    public function edit(Subject $subject)
    {
        return view('pages.admin.subject.edit', ['subject' => $subject]);
    }

    public function update(Request $request, Subject $subject)
    {
        // validate the request
        $request->validate([
            'name' => ['required', 'string', 'min:3'],
            'code' => ['required', 'string', 'min:2'],
            'description' => ['nullable', 'string'],
        ]);

        // update the subject
        $subject->update([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
        ]);

        return redirect('/admin/subjects/show')->with('success', 'Subject updated successfully');
    }

    public function destroy(Request $request, Subject $subject)
    {
        $subject->delete();
        return redirect('/admin/subjects/show')->with('success', 'Subject deleted successfully');
    }

    public function assignTeachersView()
    {
        return view('pages.admin.subject.assign-teachers', ['subjects' => Subject::all(), 'teachers' => Teacher::all()]);
    }

    public function assignTeachers(Request $request)
    {
        // validate the inputs
        $request->validate([
            'teacher' => ['required'],
            'subjects' => ['required'],
        ]);

        // Get the subjects already assigned to this teacher
        $existingSubjects = DB::table('subject_teacher')
            ->where('teacher_id', $request->teacher)
            ->pluck('subject_id')
            ->toArray();

        // Find subjects that need to be added (checked but not in the database)
        $newSubjects = array_diff($request->subjects, $existingSubjects);

        // Find subjects that need to be removed (unchecked but in the database)
        $removedSubjects = array_diff($existingSubjects, $request->subjects);

        // Insert new subjects
        if (!empty($newSubjects)) {
            foreach ($newSubjects as $subject_id) {
                DB::table('subject_teacher')->insert([
                    'subject_id' => $subject_id,
                    'teacher_id' => $request->teacher,
                    'created_at' => now(),
                ]);
            }
        }

        // Delete unassigned subjects
        if (!empty($removedSubjects)) {
            DB::table('subject_teacher')
                ->where('teacher_id', $request->teacher)
                ->whereIn('subject_id', $removedSubjects)
                ->delete();
        }
        return redirect('/admin/teachers/show')->with('success', 'Subject assiged to teacher successfully');
    }

    public function showAssignedSubjectsForTeacher(Teacher $teacher)
    {
        $subjects = $teacher->subjects;
        return response($subjects);
    }
}
