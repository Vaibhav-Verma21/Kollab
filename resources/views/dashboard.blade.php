@extends('layouts.editorial')

@section('content')
<div class="flex-grow flex flex-col md:flex-row">
    <!-- Sidebar -->
    <aside class="w-full md:w-64 border-r-2 border-black bg-[#f4f3ef] flex flex-col md:min-h-screen relative">
        <div class="p-6 border-b-2 border-black bg-yellow-300">
            <h2 class="font-bold text-xl uppercase tracking-tight">{{ Auth::user()->name }}</h2>
            <div class="font-mono text-xs mt-1 bg-white inline-block px-1 border border-black">#{{ substr(md5(Auth::id()), 0, 6) }}</div>
        </div>
        <nav class="flex-grow flex flex-col p-4 space-y-2">
            <a href="{{ route('dashboard') }}" class="font-mono text-sm font-bold uppercase bg-black text-white px-3 py-2 border-2 border-black">Overview</a>
            <a href="{{ route('catalog') }}" class="font-mono text-sm font-bold uppercase hover:bg-gray-200 px-3 py-2 border-2 border-transparent transition-colors">My Courses</a>
            <a href="{{ route('dashboard') }}" class="font-mono text-sm font-bold uppercase hover:bg-gray-200 px-3 py-2 border-2 border-transparent transition-colors">Grades</a>
            <a href="{{ route('profile.edit') }}" class="font-mono text-sm font-bold uppercase hover:bg-gray-200 px-3 py-2 border-2 border-transparent transition-colors">Settings</a>
        </nav>
        <div class="p-4 border-t-2 border-black mt-auto">
            <div class="font-mono text-xs text-gray-500 uppercase">System Status</div>
            <div class="flex items-center space-x-2 mt-1">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                <span class="font-mono text-xs font-bold">All Systems Nominal</span>
            </div>
        </div>
    </aside>

    <!-- Main Dashboard -->
    <div class="flex-grow p-4 md:p-8">
        <header class="flex justify-between items-end border-b-4 border-black pb-4 mb-8">
            <div>
                <div class="font-mono text-sm uppercase mb-1">Welcome back</div>
                <h1 class="text-4xl md:text-5xl font-bold uppercase tracking-tighter">Dashboard</h1>
            </div>
            <div class="font-mono text-sm border-2 border-black px-2 py-1 bg-white">May 19, 2026</div>
        </header>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="brutal-border p-6 bg-white brutal-shadow-sm flex flex-col relative overflow-hidden group">
                <div class="font-mono text-xs uppercase mb-2">Active Courses</div>
                <div class="text-5xl font-bold">{{ count(auth()->user()->enrolled_courses ?? []) }}</div>
                <div class="absolute -right-4 -bottom-4 text-8xl text-gray-100 group-hover:text-yellow-100 transition-colors font-bold z-0 pointer-events-none">{{ count(auth()->user()->enrolled_courses ?? []) }}</div>
            </div>
            <div class="brutal-border p-6 bg-white brutal-shadow-sm flex flex-col relative overflow-hidden group">
                <div class="font-mono text-xs uppercase mb-2">Pending Assignments</div>
                <div class="text-5xl font-bold text-red-600">0</div>
                <div class="absolute -right-4 -bottom-4 text-8xl text-gray-100 group-hover:text-red-50 transition-colors font-bold z-0 pointer-events-none">0</div>
            </div>
        </div>

        <!-- Continue Learning -->
        @php
            $enrolledIds = auth()->user()->enrolled_courses ?? [];
            $lastCourse = null;
            if (count($enrolledIds) > 0) {
                $lastCourse = \App\Models\Course::find(end($enrolledIds));
            }
        @endphp
        
        @if($lastCourse)
        <h2 class="text-2xl font-bold uppercase mb-4 border-b-2 border-black pb-2 inline-block">Jump Back In</h2>
        <div class="brutal-border bg-white flex flex-col md:flex-row mb-8 brutal-shadow hover-lift">
            <div class="bg-black w-full md:w-32 flex items-center justify-center p-4">
                <span class="text-white font-mono text-4xl font-bold">{{ strtoupper(substr($lastCourse->slug, 0, 2)) }}</span>
            </div>
            <div class="p-6 flex-grow flex flex-col justify-center">
                <div class="font-mono text-xs uppercase text-blue-600 font-bold mb-1">{{ $lastCourse->domain }}</div>
                <h3 class="text-xl font-bold uppercase mb-2">{{ $lastCourse->title }}</h3>
                <div class="w-full bg-gray-200 h-2 border border-black mb-2">
                    <div class="bg-blue-600 h-full w-[0%] border-r border-black"></div>
                </div>
                <div class="font-mono text-xs text-right">0% Complete</div>
            </div>
            <div class="p-6 flex items-center justify-center border-t-2 md:border-t-0 md:border-l-2 border-black">
                <a href="{{ route('course', $lastCourse->slug) }}" class="brutal-border bg-yellow-300 px-4 py-2 font-mono text-sm font-bold uppercase hover:bg-yellow-400 transition-colors">Resume</a>
            </div>
        </div>
        @else
        <h2 class="text-2xl font-bold uppercase mb-4 border-b-2 border-black pb-2 inline-block">Explore Courses</h2>
        <div class="brutal-border bg-white p-6 md:p-8 mb-8 brutal-shadow text-center">
            <p class="font-mono text-sm text-gray-600 mb-4">You haven't enrolled in any courses yet.</p>
            <a href="{{ route('catalog') }}" class="brutal-border bg-blue-600 text-white px-6 py-3 font-mono font-bold uppercase hover-lift inline-block">Browse Catalog</a>
        </div>
        @endif
    </div>
</div>
@endsection
