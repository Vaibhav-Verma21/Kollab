@extends('layouts.editorial')

@section('content')
<div class="flex-grow max-w-3xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <header class="mb-8 border-b-4 border-black pb-4">
        <h1 class="text-4xl font-bold uppercase tracking-tighter mb-2">Create New Thread</h1>
        <p class="font-mono text-sm text-gray-700">Start a new discussion.</p>
    </header>

    <form action="{{ route('forum.store') }}" method="POST" class="space-y-6 bg-[#f4f3ef] brutal-border p-6 md:p-8">
        @csrf
        
        <div>
            <label class="block font-mono text-sm font-bold uppercase mb-2">Category</label>
            <select name="category" class="w-full bg-white brutal-border p-3 font-mono text-sm focus:outline-none">
                <option value="Q&A">Q&A</option>
                <option value="Showcase">Showcase</option>
                <option value="General">General</option>
            </select>
            @error('category') <span class="font-mono text-xs text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-mono text-sm font-bold uppercase mb-2">Title</label>
            <input type="text" name="title" class="w-full bg-white brutal-border p-3 font-mono text-sm focus:outline-none" required placeholder="What do you want to discuss?">
            @error('title') <span class="font-mono text-xs text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-mono text-sm font-bold uppercase mb-2">Content</label>
            <textarea name="content" rows="8" class="w-full bg-white brutal-border p-3 font-mono text-sm focus:outline-none resize-none" required placeholder="Provide details, code snippets, or context..."></textarea>
            @error('content') <span class="font-mono text-xs text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end space-x-4 pt-4 border-t-2 border-black">
            <a href="{{ route('forum') }}" class="brutal-border bg-white px-6 py-3 font-mono font-bold uppercase hover:bg-gray-100 transition-colors">Cancel</a>
            <button type="submit" class="brutal-border bg-blue-600 text-white px-6 py-3 font-mono font-bold uppercase hover-lift brutal-shadow-sm">Post Thread</button>
        </div>
    </form>
</div>
@endsection
