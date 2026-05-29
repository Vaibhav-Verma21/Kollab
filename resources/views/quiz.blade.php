@extends('layouts.editorial')

@section('content')
<div class="flex-grow flex flex-col items-center justify-center bg-[#f4f3ef] p-4 md:p-8">
    <div class="w-full max-w-4xl bg-white brutal-border brutal-shadow-lg flex flex-col overflow-hidden">
        
        <!-- Header -->
        <div class="bg-blue-600 p-6 border-b-2 border-black flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <h1 class="text-3xl font-bold uppercase tracking-tighter text-white">Quiz: {{ $course->title }}</h1>
                <p class="font-mono text-xs mt-1 text-white opacity-80">{{ $course->domain }} &bull; {{ $course->level }}</p>
            </div>
            
            <div class="mt-4 md:mt-0 flex flex-col items-end">
                @if($attempt)
                    <div class="bg-yellow-300 brutal-border px-3 py-1 font-mono text-sm font-bold uppercase text-black mb-1">
                        Attempts: {{ $attempt->attempts_count }}
                    </div>
                    <div class="bg-green-400 brutal-border px-3 py-1 font-mono text-sm font-bold uppercase text-black">
                        Latest Score: {{ $attempt->latest_score }}%
                    </div>
                @else
                    <div class="bg-gray-200 brutal-border px-3 py-1 font-mono text-sm font-bold uppercase text-black">
                        First Attempt
                    </div>
                @endif
            </div>
        </div>

        <!-- Alerts -->
        @if(session('success'))
            <div class="bg-green-300 border-b-2 border-black p-4 font-mono font-bold text-center uppercase">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-400 border-b-2 border-black p-4 font-mono font-bold text-center text-white uppercase">
                {{ session('error') }}
            </div>
        @endif

        <!-- Form content -->
        <form action="{{ route('course.quiz.submit', $course->slug) }}" method="POST" class="p-6 md:p-8 bg-[#fdfdfd] flex-grow">
            @csrf

            @if($questions->isEmpty())
                <div class="text-center py-12">
                    <p class="font-mono text-lg mb-4 text-gray-500">No questions available for this quiz yet.</p>
                    <a href="{{ route('course', $course->slug) }}" class="brutal-border bg-black text-white hover:bg-gray-800 px-6 py-2 font-mono text-sm uppercase font-bold hover-lift transition-transform inline-block">Back to Course</a>
                </div>
            @else
                <div class="space-y-8">
                    @foreach($questions as $index => $question)
                        <div class="brutal-border p-6 bg-white brutal-shadow-sm hover-lift transition-transform relative group">
                            <div class="absolute -top-3 -left-3 bg-black text-white font-mono text-xs px-2 py-1 brutal-border">
                                Q{{ $index + 1 }}
                            </div>
                            
                            <h3 class="text-xl font-bold mb-4 ml-4 font-serif">{{ $question->question_text }}</h3>
                            
                            <div class="space-y-3 ml-4">
                                @foreach($question->options as $optIndex => $optionText)
                                    <label class="flex items-center space-x-3 cursor-pointer group-hover:bg-blue-50 p-2 border-2 border-transparent hover:border-black transition-colors rounded">
                                        <input type="radio" name="answers[{{ $question->_id }}]" value="{{ $optIndex }}" required class="form-radio h-5 w-5 text-blue-600 border-2 border-black focus:ring-black">
                                        <span class="font-mono text-sm text-gray-800">{{ $optionText }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 pt-8 border-t-2 border-dashed border-black flex justify-between items-center">
                    <a href="{{ route('course', $course->slug) }}" class="font-mono text-sm hover:underline text-gray-600">&larr; Back to Course</a>
                    <button type="submit" class="brutal-border bg-yellow-300 hover:bg-yellow-400 px-8 py-3 font-mono text-lg font-bold uppercase text-black brutal-shadow hover-lift transition-transform">
                        Submit Answers
                    </button>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection
