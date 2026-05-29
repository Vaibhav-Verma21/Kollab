@extends('layouts.editorial')

@section('content')
<div class="flex-grow max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 md:py-16">
    <div class="flex justify-between items-center mb-8 border-b-4 border-black pb-4">
        <h1 class="text-4xl font-bold uppercase tracking-tighter">Admin Dashboard</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-300 border-2 border-black p-4 font-mono font-bold text-center uppercase mb-6 brutal-shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="brutal-border bg-blue-300 p-6 brutal-shadow-sm flex flex-col justify-between hover-lift">
            <h3 class="font-mono font-bold uppercase text-xl mb-4">Total Users</h3>
            <div class="text-5xl font-black">{{ $stats['total_users'] }}</div>
        </div>
        
        <div class="brutal-border bg-yellow-300 p-6 brutal-shadow-sm flex flex-col justify-between hover-lift">
            <h3 class="font-mono font-bold uppercase text-xl mb-4">Courses</h3>
            <div class="text-5xl font-black">{{ $stats['total_courses'] }}</div>
            <a href="{{ route('admin.courses.create') }}" class="mt-4 border-2 border-black bg-white px-4 py-2 text-center font-mono font-bold uppercase text-xs hover:bg-gray-100 transition-colors">Add Course</a>
        </div>

        <div class="brutal-border bg-red-300 p-6 brutal-shadow-sm flex flex-col justify-between hover-lift">
            <h3 class="font-mono font-bold uppercase text-xl mb-4">Assignments</h3>
            <div class="text-5xl font-black">{{ $stats['total_assignments'] }}</div>
            <div class="flex flex-col space-y-2 mt-4">
                <a href="{{ route('admin.assignments.index') }}" class="border-2 border-black bg-white px-4 py-2 text-center font-mono font-bold uppercase text-xs hover:bg-gray-100 transition-colors">Manage Submissions</a>
                <a href="{{ route('admin.assignments.create') }}" class="border-2 border-black bg-white px-4 py-2 text-center font-mono font-bold uppercase text-xs hover:bg-gray-100 transition-colors">Add Assignment</a>
            </div>
        </div>
    </div>

</div>
@endsection
