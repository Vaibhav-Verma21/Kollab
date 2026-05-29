<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Course;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function create()
    {
        $courses = Course::all();
        return view('admin.assignments.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|string',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'rubric_names' => 'required|array',
            'rubric_names.*' => 'required|string',
            'rubric_weights' => 'required|array',
            'rubric_weights.*' => 'required|numeric|min:0|max:100',
        ]);

        // Validate weights sum to 100
        $totalWeight = array_sum($request->rubric_weights);
        if ($totalWeight != 100) {
            return back()->withErrors(['rubric' => 'Total rubric weights must equal 100%'])->withInput();
        }

        $rubric = [];
        foreach ($request->rubric_names as $index => $name) {
            $rubric[] = [
                'name' => $name,
                'weight' => (int)$request->rubric_weights[$index],
            ];
        }

        Assignment::create([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'rubric' => $rubric,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Assignment created successfully!');
    }

    public function index()
    {
        $assignments = Assignment::all();
        $courses = Course::all()->keyBy('_id');
        return view('admin.assignments.index', compact('assignments', 'courses'));
    }

    public function submissions($id)
    {
        $assignment = Assignment::findOrFail($id);
        $submissions = AssignmentSubmission::where('assignment_id', $assignment->id)->get();
        // Eager loading Users manually or via relations if defined
        $users = \App\Models\User::whereIn('_id', $submissions->pluck('user_id'))->get()->keyBy('_id');
        
        return view('admin.assignments.submissions', compact('assignment', 'submissions', 'users'));
    }

    public function grade(Request $request, $id)
    {
        $request->validate([
            'grade' => 'required|numeric|min:0|max:100',
        ]);

        $submission = AssignmentSubmission::findOrFail($id);
        $submission->update([
            'grade' => $request->grade,
            'status' => 'graded',
            'graded_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Grade submitted successfully!');
    }
}
