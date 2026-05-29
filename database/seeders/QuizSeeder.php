<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\QuizQuestion;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        $courses = Course::all();

        foreach ($courses as $course) {
            // Add 3 sample questions to each course if none exist
            if (QuizQuestion::where('course_id', $course->id)->count() === 0) {
                
                QuizQuestion::create([
                    'course_id' => $course->id,
                    'question_text' => 'What is the primary focus of ' . $course->title . '?',
                    'options' => [
                        'Basic fundamentals and history',
                        'Advanced practical applications',
                        'Theoretical concepts only',
                        'All of the above'
                    ],
                    'correct_option' => 3
                ]);

                QuizQuestion::create([
                    'course_id' => $course->id,
                    'question_text' => 'Which of the following is considered a best practice in this field?',
                    'options' => [
                        'Ignoring previous research',
                        'Continuous learning and adaptation',
                        'Using outdated methodologies',
                        'Working in complete isolation'
                    ],
                    'correct_option' => 1
                ]);

                QuizQuestion::create([
                    'course_id' => $course->id,
                    'question_text' => 'How can the skills learned in this course be applied?',
                    'options' => [
                        'Only in academic settings',
                        'They have no practical application',
                        'In various professional scenarios',
                        'Only for personal entertainment'
                    ],
                    'correct_option' => 2
                ]);
            }
        }
    }
}
