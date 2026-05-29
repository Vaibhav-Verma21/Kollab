@extends('layouts.editorial')

@section('content')
<div class="flex-grow max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 md:py-16">
    <div class="mb-4">
        <a href="{{ route('admin.dashboard') }}" class="font-mono text-sm uppercase hover:underline hover:text-blue-600">← Back to Dashboard</a>
    </div>

    <div class="flex justify-between items-center mb-8 border-b-4 border-black pb-4">
        <h1 class="text-4xl font-bold uppercase tracking-tighter">Assignments</h1>
        <a href="{{ route('admin.assignments.create') }}" class="brutal-border bg-yellow-300 hover:bg-yellow-400 px-6 py-2 font-mono font-bold uppercase text-black brutal-shadow-sm hover-lift transition-transform">
            Create Assignment
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($assignments as $assignment)
            <div class="brutal-border bg-white p-6 brutal-shadow-sm hover-lift transition-transform">
                <h3 class="font-bold text-xl mb-2">{{ $assignment->title }}</h3>
                <p class="font-mono text-sm mb-4 line-clamp-2">{{ $assignment->description }}</p>
                <div class="font-mono text-xs mb-4">
                    <strong>Course:</strong> {{ collect($courses)->get($assignment->course_id)->title ?? 'Unknown' }}<br>
                    <strong>Due:</strong> {{ \Carbon\Carbon::parse($assignment->due_date)->format('M d, Y') }}
                </div>
                <a href="{{ route('admin.assignments.submissions', $assignment->id) }}" class="block text-center brutal-border bg-blue-300 hover:bg-blue-400 py-2 font-mono font-bold uppercase text-black">
                    View Submissions
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
