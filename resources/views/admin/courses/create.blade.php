@extends('layouts.editorial')

@section('content')
<div class="flex-grow max-w-3xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 md:py-16">
    <div class="mb-4">
        <a href="{{ route('admin.dashboard') }}" class="font-mono text-sm uppercase hover:underline hover:text-blue-600">← Back to Dashboard</a>
    </div>

    <div class="brutal-border bg-white brutal-shadow p-8">
        <h1 class="text-3xl font-bold uppercase tracking-tighter mb-8 border-b-2 border-black pb-2">Create New Course</h1>

        <form action="{{ route('admin.courses.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label class="block font-mono text-sm font-bold uppercase mb-2">Course Title</label>
                <input type="text" name="title" required value="{{ old('title') }}" class="w-full brutal-border p-3 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 bg-[#f4f3ef]">
                @error('title') <span class="text-red-500 font-mono text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-mono text-sm font-bold uppercase mb-2">Description</label>
                <textarea name="description" required rows="4" class="w-full brutal-border p-3 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 bg-[#f4f3ef]">{{ old('description') }}</textarea>
                @error('description') <span class="text-red-500 font-mono text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-mono text-sm font-bold uppercase mb-2">Video URL (Optional)</label>
                <input type="url" name="video_url" placeholder="https://www.youtube.com/embed/..." value="{{ old('video_url') }}" class="w-full brutal-border p-3 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 bg-[#f4f3ef]">
                @error('video_url') <span class="text-red-500 font-mono text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="flex space-x-4">
                <div class="w-1/2">
                    <label class="block font-mono text-sm font-bold uppercase mb-2">Duration</label>
                    <input type="text" name="duration" placeholder="e.g. 10 Weeks" required value="{{ old('duration') }}" class="w-full brutal-border p-3 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 bg-[#f4f3ef]">
                    @error('duration') <span class="text-red-500 font-mono text-xs">{{ $message }}</span> @enderror
                </div>
                
                <div class="w-1/2">
                    <label class="block font-mono text-sm font-bold uppercase mb-2">Level</label>
                    <select name="level" required class="w-full brutal-border p-3 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 bg-[#f4f3ef]">
                        <option value="Beginner">Beginner</option>
                        <option value="Intermediate">Intermediate</option>
                        <option value="Advanced">Advanced</option>
                    </select>
                    @error('level') <span class="text-red-500 font-mono text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block font-mono text-sm font-bold uppercase mb-2">SVG Icon (Optional HTML)</label>
                <textarea name="icon" rows="3" class="w-full brutal-border p-3 font-mono text-xs focus:outline-none focus:ring-2 focus:ring-blue-600 bg-gray-900 text-green-400">{{ old('icon') }}</textarea>
                @error('icon') <span class="text-red-500 font-mono text-xs">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="w-full brutal-border bg-yellow-300 text-black py-4 font-bold uppercase tracking-wider brutal-shadow-sm hover-lift mt-8">
                Publish Course
            </button>
        </form>
    </div>
</div>
@endsection
