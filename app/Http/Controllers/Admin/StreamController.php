<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\SubjectStream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StreamController extends Controller
{
    public static function index() {
        // TODO: Implement index() method.
        $streams = SubjectStream::select(['id', 'stream_name'])
            ->with(['classes.students'])
            ->get()
            ->map(function ($stream) {
                $studentCount = $stream->classes->sum(fn($class) => $class->students->count());
                return [
                    'id' => $stream->id,
                    'stream_name' => $stream->stream_name,
                    'student_count' => $studentCount,
                ];
            });

//        dd($streams);
        return view('pages.admin.stream.index', ['streams' => $streams]);
    }

    public static function create() {
        return view('pages.admin.stream.add');
    }

    public static function store(Request $request) {
        // validate the user inputs
        $request->validate([
            'stream_name' => ['required', 'string', 'max:255'],
            'stream_code' => ['string', 'max:255', 'nullable'],
            'stream_description' => ['string', 'max:255', 'nullable'],
        ]);

        // insert to table
        SubjectStream::create([
            'stream_name' => $request->stream_name,
            'stream_code' => $request->stream_code,
            'stream_description' => $request->stream_description,
        ]);

        // redirect to the index page
        return redirect()->route('admin.streams.index')->with('success', 'New Subject Stream added successfully');
    }

    public static function show(SubjectStream $subjectStream) {
        // TODO: Implement show() method.
    }

    public static function edit(SubjectStream $subjectStream) {
        // TODO: Implement edit() method.
    }

    public static function update(Request $request, SubjectStream $subjectStream) {
        // TODO: Implement update() method.
    }

    public static function destroy(SubjectStream $subjectStream) {
        // TODO: Implement destroy() method.
    }

    public static function assignSubjectsView(SubjectStream $stream)
    {
        // Fetch all subjects
        $subjects = Subject::select(['id', 'name', 'code'])->get();

        // Get the IDs of subjects already assigned to the stream from the pivot table
        $assignedSubjectIds = $stream->subjects()->pluck('subjects.id')->toArray();

        return view('pages.admin.stream.assign-subjects', [
            'stream' => $stream,
            'subjects' => $subjects,
            'assignedSubjectIds' => $assignedSubjectIds
        ]);
    }


    public static function assignSubjects(Request $request, SubjectStream $stream) {
        // Validate the incoming request
        $validatedData = $request->validate([
            'subjects' => 'required|array',
            'subjects.*' => 'exists:subjects,id',
        ]);

        foreach ($validatedData['subjects'] as $subject) {
            DB::table('subject_stream_subject')->insert([
                'subject_id' => $subject,
                'subject_stream_id' => $stream->id,
                'created_at' => now(),
            ]);
        }

        // Redirect with success message
        return redirect()->route('admin.streams.index')->with('success', 'Subjects assigned to stream successfully');
    }
}
