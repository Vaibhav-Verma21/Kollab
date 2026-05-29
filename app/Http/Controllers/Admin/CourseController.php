<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration' => 'required|string',
            'level' => 'required|string',
            'icon' => 'nullable|string',
            'video_url' => 'nullable|url',
        ]);

        Course::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'duration' => $request->duration,
            'level' => $request->level,
            'icon' => $request->icon ?? 'default-icon',
            'video_url' => $request->video_url,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Course created successfully!');
    }
}
