@extends('layouts.editorial')

@section('content')
<div class="flex-grow max-w-5xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 md:py-16">
    <h1 class="text-4xl font-bold uppercase tracking-tighter mb-8 border-b-4 border-black pb-4">Peer Reviews</h1>

    @if(session('success'))
        <div class="bg-green-300 border-2 border-black p-4 font-mono font-bold text-center uppercase mb-6 brutal-shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-8">
        <div>
            <h2 class="text-2xl font-bold uppercase mb-4 flex items-center">
                <span class="w-4 h-4 bg-yellow-400 border-2 border-black mr-2"></span> Pending Reviews
            </h2>
            
            @if($pendingReviews->isEmpty())
                <div class="bg-gray-100 border-2 border-dashed border-black p-8 text-center text-gray-500 font-mono">
                    You have no pending peer reviews at this time. Check back later!
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($pendingReviews as $review)
                    <div class="brutal-border bg-white p-6 brutal-shadow-sm hover-lift transition-transform">
                        <div class="font-mono text-xs font-bold uppercase text-gray-500 mb-2">Review ID: {{ substr($review->id, -6) }}</div>
                        <h3 class="text-xl font-bold mb-4">Anonymous Submission</h3>
                        <a href="{{ route('peer_reviews.show', $review->id) }}" class="brutal-border bg-yellow-300 px-4 py-2 font-mono font-bold text-sm uppercase block text-center hover:bg-yellow-400 transition-colors">Start Review</a>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div>
            <h2 class="text-2xl font-bold uppercase mb-4 flex items-center">
                <span class="w-4 h-4 bg-green-400 border-2 border-black mr-2"></span> Completed Reviews
            </h2>
            
            @if($completedReviews->isEmpty())
                <div class="bg-gray-100 border-2 border-dashed border-black p-8 text-center text-gray-500 font-mono">
                    No completed reviews yet.
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($completedReviews as $review)
                    <div class="brutal-border bg-gray-50 p-6 opacity-75">
                        <div class="flex justify-between items-center mb-2">
                            <div class="font-mono text-xs font-bold uppercase text-gray-500">Review ID: {{ substr($review->id, -6) }}</div>
                            <div class="font-mono text-xs font-bold uppercase bg-green-200 border border-black px-2 py-1">Score: {{ $review->total_score }}%</div>
                        </div>
                        <h3 class="text-xl font-bold mb-4">Anonymous Submission</h3>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
