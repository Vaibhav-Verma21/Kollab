@extends('layouts.editorial')

@section('content')
<div class="flex-grow max-w-5xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <div class="mb-6">
        <a href="{{ route('forum') }}" class="font-mono text-sm uppercase font-bold hover:underline">&larr; Back to Forum</a>
    </div>

    <!-- Original Thread -->
    <div class="brutal-border bg-white p-6 md:p-8 brutal-shadow mb-8">
        <div class="flex justify-between items-start mb-6">
            <span class="bg-yellow-300 border border-black font-mono text-[10px] uppercase px-2 py-1 font-bold">{{ $thread->category }}</span>
            <span class="font-mono text-xs text-gray-500">{{ $thread->created_at->format('M d, Y h:i A') }}</span>
        </div>
        
        <h1 class="text-3xl md:text-5xl font-bold mb-6">{{ $thread->title }}</h1>
        
        <div class="font-mono text-base text-gray-800 whitespace-pre-wrap mb-8">{{ $thread->content }}</div>
        
        <div class="flex items-center space-x-4 border-t-2 border-black pt-6">
            <div class="w-10 h-10 bg-black border-2 border-black rounded-full flex items-center justify-center text-lg font-bold text-white uppercase">{{ substr($thread->user->name ?? '?', 0, 1) }}</div>
            <div>
                <div class="font-mono text-sm font-bold uppercase">{{ $thread->user->name ?? 'Unknown' }}</div>
                <div class="font-mono text-xs text-gray-500">Original Poster</div>
            </div>
        </div>
    </div>

    <!-- Replies -->
    <h2 class="text-2xl font-bold uppercase mb-6 border-b-2 border-black pb-2">Replies ({{ $thread->replies->count() }})</h2>
    
    <div class="space-y-6 mb-12">
        @forelse($thread->replies as $reply)
        <div class="brutal-border bg-[#f4f3ef] p-6 group">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-blue-600 border border-black rounded-full flex items-center justify-center text-xs font-bold text-white uppercase">{{ substr($reply->user->name ?? '?', 0, 1) }}</div>
                    <span class="font-mono text-sm font-bold uppercase">{{ $reply->user->name ?? 'Unknown' }}</span>
                </div>
                <span class="font-mono text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>
            </div>
            <div class="font-mono text-sm text-gray-800 whitespace-pre-wrap">{{ $reply->content }}</div>
        </div>
        @empty
        <div class="text-center p-8 border-2 border-dashed border-black bg-white">
            <p class="font-mono text-lg font-bold mb-1">No replies yet.</p>
            <p class="font-mono text-sm text-gray-500">Have something to add? Reply below!</p>
        </div>
        @endforelse
    </div>

    <!-- Reply Form -->
    @auth
    <div class="brutal-border bg-white p-6 md:p-8 brutal-shadow-sm">
        <h3 class="text-xl font-bold uppercase mb-4">Add a Reply</h3>
        <form action="{{ route('forum.reply', $thread->id) }}" method="POST">
            @csrf
            <textarea name="content" rows="4" class="w-full bg-gray-50 brutal-border p-4 font-mono text-sm focus:outline-none focus:bg-white resize-none mb-4" required placeholder="Type your response..."></textarea>
            @error('content') <span class="block font-mono text-xs text-red-600 mb-4">{{ $message }}</span> @enderror
            
            <div class="flex justify-end">
                <button type="submit" class="brutal-border bg-black text-white px-8 py-3 font-mono font-bold uppercase hover-lift">Post Reply</button>
            </div>
        </form>
    </div>
    @else
    <div class="brutal-border bg-yellow-300 p-6 text-center">
        <p class="font-mono text-sm font-bold uppercase mb-4">You must be logged in to reply.</p>
        <a href="{{ route('login') }}" class="brutal-border bg-black text-white px-6 py-2 font-mono text-sm font-bold uppercase hover-lift inline-block">Log In</a>
    </div>
    @endauth
</div>
@endsection
