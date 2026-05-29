<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    public function show($courseSlug, $assignmentId)
    {
        $course = Course::where('slug', $courseSlug)->firstOrFail();
        $assignment = Assignment::findOrFail($assignmentId);
        
        $submission = AssignmentSubmission::where('assignment_id', $assignment->id)
                                          ->where('user_id', Auth::id())
                                          ->first();

        return view('assignment', compact('course', 'assignment', 'submission'));
    }

    public function submit(Request $request, $courseSlug, $assignmentId)
    {
        $request->validate([
            'github_url' => 'required|url',
            'notes' => 'nullable|string',
        ]);

        $course = Course::where('slug', $courseSlug)->firstOrFail();
        $assignment = Assignment::findOrFail($assignmentId);

        $submission = AssignmentSubmission::updateOrCreate(
            [
                'assignment_id' => $assignment->id,
                'user_id' => Auth::id()
            ],
            [
                'github_url' => $request->github_url,
                'notes' => $request->notes,
                'status' => 'submitted'
            ]
        );

        // Assign up to 10 peers who are also enrolled in the course
        $peers = \App\Models\User::where('_id', '!=', Auth::id())
            ->get()
            ->filter(function ($user) use ($course) {
                $enrolled = $user->enrolled_courses ?? [];
                return in_array((string)$course->id, array_map('strval', $enrolled));
            })
            ->shuffle()
            ->take(10);

        foreach ($peers as $peer) {
            \App\Models\PeerReview::firstOrCreate([
                'submission_id' => $submission->id,
                'reviewer_id' => $peer->id,
            ], [
                'is_completed' => false,
            ]);
        }

        return redirect()->back()->with('success', 'Assignment submitted successfully. It will be peer-reviewed soon.');
    }
}
