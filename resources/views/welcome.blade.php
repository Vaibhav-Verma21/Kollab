@extends('layouts.editorial')

@section('content')
<div class="flex-grow flex flex-col">
    <!-- Hero Section -->
    <section class="border-b-2 border-black grid grid-cols-1 md:grid-cols-2">
        <div class="p-8 md:p-16 flex flex-col justify-center border-b-2 md:border-b-0 md:border-r-2 border-black relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4 font-mono text-xs text-gray-500 uppercase tracking-widest">[v2.0 Beta]</div>
            <h1 class="text-6xl md:text-8xl font-bold tracking-tighter leading-none mb-6 uppercase">
                Learn <br>
                <span class="text-transparent" style="-webkit-text-stroke: 2px #111;">Together.</span> <br>
                Faster.
            </h1>
            <p class="font-mono text-lg max-w-md mb-8 border-l-4 border-yellow-400 pl-4">
                A collaborative learning platform that treats students like peers. Stop watching videos in isolation. Start building together.
            </p>
            <div class="flex space-x-4">
                <a href="{{ route('catalog') }}" class="brutal-border px-8 py-3 bg-blue-600 text-white font-bold uppercase tracking-wider brutal-shadow hover-lift">Explore Courses</a>
                @guest
                <a href="{{ route('register') }}" class="brutal-border px-8 py-3 bg-white font-bold uppercase tracking-wider brutal-shadow hover-lift">Sign Up</a>
                @endguest
            </div>
        </div>
        <div class="bg-yellow-300 relative p-8 flex items-center justify-center min-h-[400px]">
            <!-- Decorative abstract element -->
            <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(#111 1.5px, transparent 1.5px); background-size: 24px 24px;"></div>
            <div class="brutal-border bg-white p-6 max-w-sm w-full relative z-10 brutal-shadow transform rotate-2">
                <div class="flex items-center space-x-2 mb-4 border-b-2 border-black pb-2">
                    <div class="w-3 h-3 bg-red-500 rounded-full border border-black"></div>
                    <div class="w-3 h-3 bg-yellow-500 rounded-full border border-black"></div>
                    <div class="w-3 h-3 bg-green-500 rounded-full border border-black"></div>
                </div>
                <div class="font-mono text-xs mb-2 text-gray-500">// index.js</div>
                <div class="font-mono text-sm leading-relaxed">
                    <span class="text-blue-600">function</span> <span class="text-black font-bold">collaborate</span>() {<br>
                    &nbsp;&nbsp;<span class="text-blue-600">const</span> minds = <span class="text-yellow-600">connect</span>();<br>
                    &nbsp;&nbsp;<span class="text-blue-600">return</span> minds.<span class="text-yellow-600">build</span>(<span class="text-green-600">'future'</span>);<br>
                    }
                </div>
                <!-- Simulated Cursor -->
                <div class="absolute top-24 left-32 flex flex-col items-center">
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none" class="text-blue-600"><path d="M1 1L6 14L8.5 9L14 7L1 1Z" fill="currentColor" stroke="black" stroke-width="1.5"/></svg>
                    <div class="bg-blue-600 text-white font-mono text-[10px] px-1 ml-4 mt-1 border border-black">Alice</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="grid grid-cols-1 md:grid-cols-3">
        <div class="p-8 border-b-2 md:border-b-0 md:border-r-2 border-black group hover:bg-yellow-100 transition-colors">
            <div class="font-mono text-4xl font-bold mb-4">01</div>
            <h3 class="text-2xl font-bold uppercase mb-2">Real-time Workspaces</h3>
            <p class="font-mono text-sm">Code, write, and design together in synchronized environments. No more screen sharing lag.</p>
        </div>
        <div class="p-8 border-b-2 md:border-b-0 md:border-r-2 border-black group hover:bg-blue-100 transition-colors">
            <div class="font-mono text-4xl font-bold mb-4">02</div>
            <h3 class="text-2xl font-bold uppercase mb-2">Editorial Forums</h3>
            <p class="font-mono text-sm">Discussions that don't look like 1999. Threaded, distraction-free, and heavily focused on typography.</p>
        </div>
        <div class="p-8 group hover:bg-pink-100 transition-colors">
            <div class="font-mono text-4xl font-bold mb-4">03</div>
            <h3 class="text-2xl font-bold uppercase mb-2">Peer Reviews</h3>
            <p class="font-mono text-sm">Submit assignments and get graded by your peers using our rigid, rubric-based evaluation system.</p>
        </div>
    </section>
</div>
@endsection
