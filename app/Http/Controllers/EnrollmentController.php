<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function store(Request $request, $courseId)
    {
        $user = Auth::user();
        
        $enrolled = $user->enrolled_courses ?? [];
        
        if (!in_array($courseId, $enrolled)) {
            $enrolled[] = $courseId;
            $user->enrolled_courses = $enrolled;
            $user->save();
        }
        
        return back()->with('status', 'enrolled');
    }
}
