@extends('layouts.editorial')

@section('content')
<div class="flex-grow max-w-5xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 md:py-16">
    
    <div class="mb-4">
        <a href="{{ route('course', $course->slug) }}" class="font-mono text-sm uppercase hover:underline hover:text-blue-600">← Back to Course</a>
    </div>

    @if(session('success'))
        <div class="bg-green-300 border-2 border-black p-4 font-mono font-bold text-center uppercase mb-6 brutal-shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="brutal-border bg-white brutal-shadow">
        <!-- Header -->
        <header class="border-b-2 border-black p-8 bg-yellow-300 relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 text-[10rem] font-bold text-yellow-400 leading-none z-0 pointer-events-none uppercase opacity-50">ASG</div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <span class="bg-black text-white font-mono text-xs uppercase px-2 py-1 font-bold">{{ $course->title }}</span>
                    <span class="font-mono text-xs border-2 border-black px-2 py-1 bg-white font-bold text-red-600 uppercase">Due: {{ \Carbon\Carbon::parse($assignment->due_date)->format('M d, Y h:i A') }}</span>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold uppercase tracking-tighter mb-4">{{ $assignment->title }}</h1>
            </div>
        </header>

        <div class="flex flex-col md:flex-row">
            <!-- Instructions -->
            <div class="w-full md:w-1/2 p-8 border-b-2 md:border-b-0 md:border-r-2 border-black bg-[#f4f3ef]">
                <h2 class="text-2xl font-bold uppercase mb-6 border-b-2 border-black pb-2">Requirements</h2>
                <div class="prose prose-sm font-mono max-w-none text-gray-800">
                    <p>{{ $assignment->description }}</p>
                    
                    <p class="font-bold mt-6">Evaluation Rubric:</p>
                    <div class="bg-white border border-black p-4 mt-2 mb-4">
                        @foreach($assignment->rubric as $criteria)
                        <div class="flex justify-between border-b border-gray-300 pb-2 mb-2 last:border-0 last:mb-0 last:pb-0">
                            <span>{{ $criteria['name'] }}</span>
                            <span class="font-bold">{{ $criteria['weight'] }}%</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Submission Form -->
            <div class="w-full md:w-1/2 p-8 bg-white flex flex-col justify-center">
                <h2 class="text-2xl font-bold uppercase mb-6 border-b-2 border-black pb-2">Submit Work</h2>
                
                @if($submission)
                    <div class="bg-gray-100 border-2 border-black p-6 text-center">
                        <svg class="mx-auto h-12 w-12 text-green-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="font-bold font-mono text-lg uppercase mb-2">Assignment Submitted</h3>
                        <p class="font-mono text-sm text-gray-600 mb-2">Status: <span class="font-bold uppercase">{{ $submission->status }}</span></p>
                        @if($submission->grade !== null)
                            <div class="font-mono text-sm text-gray-600 mb-4 border-t border-gray-300 pt-2 mt-2">
                                <span class="uppercase font-bold text-xs">Final Grade:</span><br>
                                <span class="font-bold text-2xl text-black">{{ $submission->grade }}/100</span>
                                @if($submission->graded_by)
                                    <br><span class="text-[10px] text-red-500 uppercase">Admin Reviewed</span>
                                @else
                                    <br><span class="text-[10px] text-blue-500 uppercase">Peer Reviewed</span>
                                @endif
                            </div>
                        @else
                            <div class="mb-4"></div>
                        @endif
                        <a href="{{ $submission->github_url }}" target="_blank" class="text-blue-600 hover:underline font-mono text-sm block truncate">{{ $submission->github_url }}</a>
                    </div>
                @else
                    <form action="{{ route('course.assignment.submit', ['slug' => $course->slug, 'id' => $assignment->id]) }}" method="POST" class="space-y-6 flex-grow flex flex-col">
                        @csrf
                        <div>
                            <label class="block font-mono text-sm font-bold uppercase mb-2">GitHub Repository URL</label>
                            <input type="url" name="github_url" required placeholder="https://github.com/username/repo" class="w-full brutal-border p-3 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 bg-[#f4f3ef]">
                        </div>
                        
                        <div class="flex-grow">
                            <label class="block font-mono text-sm font-bold uppercase mb-2">Additional Notes (Optional)</label>
                            <textarea name="notes" rows="4" placeholder="Any specific instructions for the peer reviewer?" class="w-full h-full brutal-border p-3 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 bg-[#f4f3ef] resize-none"></textarea>
                        </div>

                        <button type="submit" class="w-full brutal-border bg-black text-white py-4 font-bold uppercase tracking-wider brutal-shadow hover-lift mt-auto">
                            Submit Assignment
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
