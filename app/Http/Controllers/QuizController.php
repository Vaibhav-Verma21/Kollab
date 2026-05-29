<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\QuizAttempt;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function show($slug)
    {
        $course = Course::where('slug', $slug)->firstOrFail();
        
        $questions = QuizQuestion::where('course_id', $course->id)->get();
        
        $attempt = null;
        if (Auth::check()) {
            $attempt = QuizAttempt::where('user_id', Auth::id())
                                  ->where('course_id', $course->id)
                                  ->first();
        }

        return view('quiz', compact('course', 'questions', 'attempt'));
    }

    public function submit(Request $request, $slug)
    {
        $course = Course::where('slug', $slug)->firstOrFail();
        $questions = QuizQuestion::where('course_id', $course->id)->get();
        
        if ($questions->isEmpty()) {
            return redirect()->back()->with('error', 'No questions available for this course quiz.');
        }

        $answers = $request->input('answers', []);
        $score = 0;

        foreach ($questions as $question) {
            $questionId = (string) $question->_id;
            if (isset($answers[$questionId]) && (int)$answers[$questionId] === (int)$question->correct_option) {
                $score++;
            }
        }

        $percentageScore = ($score / $questions->count()) * 100;

        $attempt = QuizAttempt::where('user_id', Auth::id())
                              ->where('course_id', $course->id)
                              ->first();

        if ($attempt) {
            $attempt->attempts_count += 1;
            $attempt->latest_score = $percentageScore;
            $attempt->save();
        } else {
            QuizAttempt::create([
                'user_id' => Auth::id(),
                'course_id' => $course->id,
                'attempts_count' => 1,
                'latest_score' => $percentageScore,
            ]);
        }

        return redirect()->back()->with('success', "You scored {$score} out of {$questions->count()} ({$percentageScore}%)!");
    }
}
