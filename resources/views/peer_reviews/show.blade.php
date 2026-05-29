@extends('layouts.editorial')

@section('content')
<div class="flex-grow max-w-5xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 md:py-16">
    <div class="mb-4 flex justify-between items-center">
        <a href="{{ route('peer_reviews.index') }}" class="font-mono text-sm uppercase hover:underline hover:text-blue-600">← Back to Reviews</a>
        <div class="bg-yellow-300 font-mono font-bold text-xs uppercase px-2 py-1 border-2 border-black">Anonymous Review</div>
    </div>

    <div class="brutal-border bg-white brutal-shadow flex flex-col md:flex-row">
        
        <!-- Submission Details -->
        <div class="w-full md:w-1/2 p-8 border-b-2 md:border-b-0 md:border-r-2 border-black bg-[#f4f3ef]">
            <h1 class="text-3xl font-bold uppercase tracking-tighter mb-6 border-b-2 border-black pb-2">Submission Details</h1>
            
            <div class="mb-8">
                <h3 class="font-mono text-sm font-bold uppercase text-gray-500 mb-2">Assignment Context</h3>
                <h2 class="text-xl font-bold mb-2">{{ $assignment->title }}</h2>
                <p class="font-mono text-sm text-gray-800">{{ $assignment->description }}</p>
            </div>

            <div class="mb-8 p-4 bg-white border-2 border-black">
                <h3 class="font-mono text-sm font-bold uppercase mb-4">Submitted Work</h3>
                <a href="{{ $submission->github_url }}" target="_blank" class="flex items-center space-x-2 text-blue-600 hover:text-blue-800 transition-colors bg-blue-50 p-3 border border-blue-200">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-bold font-mono">View GitHub Repository</span>
                </a>
            </div>

            @if($submission->notes)
            <div class="mb-4">
                <h3 class="font-mono text-sm font-bold uppercase text-gray-500 mb-2">Author's Notes</h3>
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 font-mono text-sm">
                    {{ $submission->notes }}
                </div>
            </div>
            @endif
        </div>

        <!-- Grading Rubric -->
        <div class="w-full md:w-1/2 p-8 bg-white">
            <h2 class="text-2xl font-bold uppercase mb-6 border-b-2 border-black pb-2">Grading Rubric</h2>
            
            <form action="{{ route('peer_reviews.submit', $review->id) }}" method="POST">
                @csrf
                
                <div class="space-y-6 mb-8">
                    @foreach($assignment->rubric as $index => $criteria)
                    <div class="bg-[#fafafa] border-2 border-black p-4 brutal-shadow-xs">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-bold font-mono">{{ $criteria['name'] }}</h4>
                            <span class="bg-black text-white font-mono text-xs px-2 py-1">{{ $criteria['weight'] }}%</span>
                        </div>
                        <div class="mt-4">
                            <label class="block font-mono text-xs uppercase text-gray-500 mb-2">Score (0-100)</label>
                            <input type="number" name="scores[{{ $index }}]" min="0" max="100" required class="w-24 brutal-border p-2 font-mono text-center focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mb-8">
                    <label class="block font-mono text-sm font-bold uppercase mb-2">Constructive Feedback</label>
                    <textarea name="comments" rows="5" required placeholder="Provide helpful feedback to your peer..." class="w-full brutal-border p-3 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 bg-[#f4f3ef] resize-y"></textarea>
                </div>

                <button type="submit" class="w-full brutal-border bg-black text-white py-4 font-bold uppercase tracking-wider brutal-shadow hover-lift">
                    Submit Peer Review
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
