@extends('layouts.editorial')

@section('content')
    <div class="flex-grow max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        <!-- Forum Header -->
        <header class="mb-12 border-b-4 border-black pb-8">
            <div class="flex justify-between items-end">
                <div>
                    <h1 class="text-5xl md:text-7xl font-bold uppercase tracking-tighter mb-2">Forum</h1>
                    <p class="font-mono text-lg max-w-2xl text-gray-700">Intellectual sparring and collaborative problem
                        solving.</p>
                </div>
                <a href="{{ route('forum.create') }}"
                    class="brutal-border bg-blue-600 text-white px-6 py-3 font-bold uppercase tracking-wider brutal-shadow hover-lift hidden md:block">
                    New Thread
                </a>
            </div>
        </header>

        <div class="flex flex-col md:flex-row gap-12">
            <!-- Main Thread List -->
            <div class="flex-grow">
                <!-- Categories / Tabs -->
                <div class="flex space-x-1 mb-8 border-b-2 border-black">
                    <a href="{{ route('forum') }}"
                        class="px-6 py-2 {{ $category === 'All' ? 'bg-black text-white border-black' : 'bg-transparent text-black hover:bg-gray-200 border-transparent hover:border-black' }} font-mono font-bold uppercase text-sm transition-colors border-t-2 border-r-2 border-l-2">All</a>
                    <a href="{{ route('forum', ['category' => 'Q&A']) }}"
                        class="px-6 py-2 {{ $category === 'Q&A' ? 'bg-black text-white border-black' : 'bg-transparent text-black hover:bg-gray-200 border-transparent hover:border-black' }} font-mono font-bold uppercase text-sm transition-colors border-t-2 border-r-2 border-l-2">Q&A</a>
                    <a href="{{ route('forum', ['category' => 'Showcase']) }}"
                        class="px-6 py-2 {{ $category === 'Showcase' ? 'bg-black text-white border-black' : 'bg-transparent text-black hover:bg-gray-200 border-transparent hover:border-black' }} font-mono font-bold uppercase text-sm transition-colors border-t-2 border-r-2 border-l-2">Showcase</a>
                </div>

                <!-- Threads -->
                <div class="space-y-6">
                    @forelse($threads as $thread)
                        <a href="{{ route('forum.show', $thread->id) }}"
                            class="block brutal-border bg-white p-6 brutal-shadow-sm hover-lift group {{ $loop->even ? 'bg-[#f4f3ef] border-dashed' : '' }}">
                            <div class="flex justify-between items-start mb-4">
                                <span
                                    class="bg-yellow-300 border border-black font-mono text-[10px] uppercase px-2 py-1 font-bold">{{ $thread->category }}</span>
                                <span class="font-mono text-xs text-gray-500">{{ $thread->created_at->diffForHumans() }}</span>
                            </div>
                            <h3 class="text-2xl font-bold mb-2 group-hover:text-blue-600 transition-colors">{{ $thread->title }}
                            </h3>
                            <p class="font-mono text-sm text-gray-700 mb-6 line-clamp-2">{{ $thread->content }}</p>
                            <div class="flex items-center justify-between border-t-2 border-black pt-4">
                                <div class="flex items-center space-x-2">
                                    <div
                                        class="w-6 h-6 bg-red-500 border border-black rounded-full flex items-center justify-center text-[10px] font-bold text-white">
                                        {{ substr($thread->user->name ?? '?', 0, 1) }}</div>
                                    <span
                                        class="font-mono text-xs font-bold uppercase">{{ $thread->user->name ?? 'Unknown' }}</span>
                                </div>
                                <div class="flex space-x-4 font-mono text-xs font-bold">
                                    <span class="text-gray-500">👁 {{ $thread->views }}</span>
                                    <span class="text-gray-500">💬 {{ $thread->replies()->count() }}</span>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="brutal-border bg-white p-6 brutal-shadow-sm text-center">
                            <p class="font-mono text-lg font-bold mb-2">No threads found.</p>
                            <p class="font-mono text-sm text-gray-500">Be the first to start a discussion in this category!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Sidebar -->
            <div class="w-full md:w-80 flex-shrink-0 space-y-8">
                <a href="{{ route('forum.create') }}"
                    class="w-full text-center block brutal-border bg-blue-600 text-white px-6 py-4 font-bold uppercase tracking-wider brutal-shadow hover-lift md:hidden mb-8">
                    New Thread
                </a>

                <!-- Guidelines Container -->
                <div class="brutal-border bg-white p-6">
                    <h3 class="font-mono font-bold uppercase mb-4 border-b-2 border-black pb-2">Forum Rules</h3>
                    <ul class="font-mono text-sm space-y-3 list-decimal list-inside text-gray-700">
                        <li>Search before asking.</li>
                        <li>Format code blocks properly.</li>
                        <li>Be direct, but kind.</li>
                        <li>No generic "it doesn't work" posts. Include logs.</li>
                    </ul>
                </div>

                <!-- Top Contributors -->
                <div class="brutal-border bg-yellow-300 p-6 brutal-shadow-sm">
                    <h3 class="font-mono font-bold uppercase mb-4 border-b-2 border-black pb-2">Top Mentors</h3>
                    <div class="space-y-4 mt-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <div
                                    class="w-8 h-8 bg-black border-2 border-black rounded-full flex items-center justify-center text-white font-mono text-xs">
                                    J</div>
                                <span class="font-mono text-sm font-bold uppercase">JaneDoe</span>
                            </div>
                            <span class="font-mono text-xs text-blue-800 bg-blue-200 px-1 border border-black">9.2k
                                rep</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <div
                                    class="w-8 h-8 bg-white border-2 border-black rounded-full flex items-center justify-center text-black font-mono text-xs">
                                    M</div>
                                <span class="font-mono text-sm font-bold uppercase">Mike_Code</span>
                            </div>
                            <span class="font-mono text-xs text-blue-800 bg-blue-200 px-1 border border-black">8.5k
                                rep</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection