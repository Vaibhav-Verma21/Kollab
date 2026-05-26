@extends('layouts.editorial')

@section('content')
    <div class="flex-grow flex flex-col md:flex-row">
        <!-- Sidebar (same as dashboard) -->
        <aside class="w-full md:w-64 border-r-2 border-black bg-[#f4f3ef] flex flex-col md:min-h-screen relative">
            <div class="p-6 border-b-2 border-black bg-yellow-300">
                <h2 class="font-bold text-xl uppercase tracking-tight">{{ Auth::user()->name }}</h2>
                <div class="font-mono text-xs mt-1 bg-white inline-block px-1 border border-black">
                    #{{ substr(md5(Auth::id()), 0, 6) }}</div>
            </div>
            <nav class="flex-grow flex flex-col p-4 space-y-2">
                <a href="{{ route('dashboard') }}"
                    class="font-mono text-sm font-bold uppercase hover:bg-gray-200 px-3 py-2 border-2 border-transparent transition-colors">Overview</a>
                <a href="{{ route('my-courses') }}"
                    class="font-mono text-sm font-bold uppercase bg-black text-white px-3 py-2 border-2 border-black">My Courses</a>
                <a href="{{ route('profile.edit') }}"
                    class="font-mono text-sm font-bold uppercase hover:bg-gray-200 px-3 py-2 border-2 border-transparent transition-colors">Settings</a>
            </nav>
            <div class="p-4 border-t-2 border-black mt-auto">
                <div class="font-mono text-xs text-gray-500 uppercase">System Status</div>
                <div class="flex items-center space-x-2 mt-1">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="font-mono text-xs font-bold">All Systems Nominal</span>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-grow p-4 md:p-8">
            <header class="flex justify-between items-end border-b-4 border-black pb-4 mb-8">
                <div>
                    <div class="font-mono text-sm uppercase mb-1">Your learning</div>
                    <h1 class="text-4xl md:text-5xl font-bold uppercase tracking-tighter">My Courses</h1>
                </div>
                <span class="font-mono text-xs border-2 border-black px-2 py-1 bg-white">
                    {{ $courses->count() }} enrolled
                </span>
            </header>

            @if($courses->isEmpty())
                {{-- Empty state --}}
                <div class="brutal-border bg-white p-10 brutal-shadow text-center max-w-lg mx-auto mt-12">
                    <div class="text-6xl mb-4">📚</div>
                    <h2 class="text-2xl font-bold uppercase mb-2">No courses yet</h2>
                    <p class="font-mono text-sm text-gray-600 mb-6">
                        You haven't enrolled in any courses. Browse the catalog to get started.
                    </p>
                    <a href="{{ route('catalog') }}"
                       class="brutal-border bg-blue-600 text-white px-6 py-3 font-mono font-bold uppercase hover-lift inline-block">
                        Browse Catalog
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($courses as $course)
                        <a href="{{ route('course', $course->slug) }}"
                           class="brutal-border bg-white flex flex-col brutal-shadow hover-lift group block">

                            {{-- Thumbnail --}}
                            <div class="h-36 border-b-2 border-black {{ $course->theme_color ?? 'bg-blue-200' }} flex items-center justify-center relative overflow-hidden">
                                <h2 class="text-5xl font-bold uppercase z-10 text-white"
                                    style="-webkit-text-stroke: 2px #111;">
                                    {{ strtoupper(substr($course->slug, 0, 4)) }}
                                </h2>
                            </div>

                            {{-- Body --}}
                            <div class="p-5 flex flex-col flex-grow">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="bg-black text-white font-mono text-[10px] uppercase px-2 py-1">
                                        {{ $course->domain }}
                                    </span>
                                    <span class="font-mono text-xs font-bold">{{ $course->duration }}</span>
                                </div>
                                <h3 class="text-xl font-bold uppercase mb-1 group-hover:text-blue-600 transition-colors">
                                    {{ $course->title }}
                                </h3>
                                <p class="font-mono text-sm text-gray-600 flex-grow mb-4 line-clamp-2">
                                    {{ $course->description }}
                                </p>

                                {{-- Progress bar --}}
                                <div class="mt-auto">
                                    <div class="w-full bg-gray-200 h-2 border border-black mb-1">
                                        <div class="bg-blue-600 h-full w-[0%] border-r border-black"></div>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="font-mono text-xs text-gray-500">0% complete</span>
                                        <span class="font-mono text-xs font-bold uppercase underline decoration-2">
                                            Continue →
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- Browse more CTA --}}
                <div class="mt-10 pt-8 border-t-2 border-black flex items-center justify-between">
                    <p class="font-mono text-sm text-gray-500">Want to learn more?</p>
                    <a href="{{ route('catalog') }}"
                       class="brutal-border bg-black text-white font-mono text-xs uppercase px-5 py-2 hover:bg-gray-800 transition-colors">
                        Browse Catalog
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
