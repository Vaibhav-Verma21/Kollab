<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Note;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    // All domains that exist in the seeder — update this if you add new ones.
    const DOMAINS = [
        'Business',
        'Cybersecurity',
        'Data Science',
        'Design',
        'Development',
        'Health & Wellness',
        'Science',
        'Theory',
    ];

    public function index(Request $request)
    {
        $query  = Course::query();
        $search = $request->input('search', '');
        $domain = $request->input('domain', 'All');
        $level  = $request->input('level', 'All');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('domain', 'like', "%{$search}%");
            });
        }

        if ($domain && $domain !== 'All') {
            $query->where('domain', $domain);
        }

        if ($level && $level !== 'All') {
            $query->where('level', $level);
        }

        $courses = $query->get();
        $domains = collect(self::DOMAINS);
        $levels  = ['Beginner', 'Intermediate', 'Advanced'];

        return view('catalog', compact('courses', 'search', 'domain', 'level', 'domains', 'levels'));
    }

    public function myEnrolled()
    {
        $enrolledIds = auth()->user()->enrolled_courses ?? [];
        $courses     = count($enrolledIds)
            ? Course::whereIn('id', $enrolledIds)->get()
            : collect();

        return view('my-courses', compact('courses'));
    }

    public function show($slug)
    {
        $course = Course::where('slug', $slug)->firstOrFail();

        $noteContent = '';
        if (Auth::check()) {
            $note = Note::where('user_id', Auth::id())
                        ->where('course_id', $course->id)
                        ->first();
            if ($note) {
                $noteContent = $note->content;
            }
        }

        $assignments = Assignment::where('course_id', $course->id)->get();

        return view('course', compact('course', 'noteContent', 'assignments'));
    }
}
