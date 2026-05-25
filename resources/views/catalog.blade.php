@extends('layouts.editorial')

@section('content')
    <div class="flex-grow">
        {{-- ── Header ─────────────────────────────────────────────────────────── --}}
        <header class="border-b-2 border-black bg-blue-600 text-white p-8 md:p-16">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-5xl md:text-7xl font-bold uppercase tracking-tighter mb-4">Course Catalog</h1>
                <p class="font-mono text-lg max-w-2xl border-l-4 border-yellow-300 pl-4">
                    Discover structured paths to master new skills. High-signal, low-noise.
                </p>
            </div>
        </header>

        {{-- ── Toolbar ─────────────────────────────────────────────────────────── --}}
        <div class="border-b-2 border-black bg-white sticky top-16 z-50">
            <form id="filter-form" method="GET" action="{{ route('catalog') }}"
                  class="max-w-7xl mx-auto flex flex-col md:flex-row border-l-2 border-r-2 border-black">

                {{-- ── Domain custom dropdown ── --}}
                <div class="relative border-b-2 md:border-b-0 md:border-r-2 border-black" id="domain-wrap">
                    <input type="hidden" name="domain" id="input-domain" value="{{ $domain ?? 'All' }}">
                    <button type="button" id="domain-btn"
                            class="flex items-center gap-3 px-5 py-4 w-full font-mono text-xs uppercase font-bold hover:bg-gray-50 transition-colors select-none">
                        <span class="font-mono text-[10px] text-gray-400 uppercase tracking-widest">Domain</span>
                        <span id="domain-label" class="font-bold">{{ $domain ?? 'All' }}</span>
                        <svg id="domain-chevron" class="w-3 h-3 ml-auto transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div id="domain-panel"
                         class="hidden absolute top-full left-0 bg-white border-2 border-black border-t-0 min-w-full z-[100] shadow-[4px_4px_0_#000]">
                        @foreach(array_merge(['All'], $domains->toArray()) as $d)
                        <button type="button"
                                data-domain="{{ $d }}"
                                class="domain-opt block w-full text-left px-5 py-3 font-mono text-xs uppercase hover:bg-black hover:text-white transition-colors border-b border-gray-100 last:border-0
                                       {{ ($domain ?? 'All') === $d ? 'bg-black text-white' : '' }}">
                            {{ $d }}
                        </button>
                        @endforeach
                    </div>
                </div>

                {{-- ── Level custom dropdown ── --}}
                <div class="relative border-b-2 md:border-b-0 md:border-r-2 border-black" id="level-wrap">
                    <input type="hidden" name="level" id="input-level" value="{{ $level ?? 'All' }}">
                    <button type="button" id="level-btn"
                            class="flex items-center gap-3 px-5 py-4 w-full font-mono text-xs uppercase font-bold hover:bg-gray-50 transition-colors select-none">
                        <span class="font-mono text-[10px] text-gray-400 uppercase tracking-widest">Level</span>
                        <span id="level-label" class="font-bold">{{ $level ?? 'All' }}</span>
                        <svg id="level-chevron" class="w-3 h-3 ml-auto transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div id="level-panel"
                         class="hidden absolute top-full left-0 bg-white border-2 border-black border-t-0 min-w-full z-[100] shadow-[4px_4px_0_#000]">
                        @foreach(['All', 'Beginner', 'Intermediate', 'Advanced'] as $l)
                        <button type="button"
                                data-level="{{ $l }}"
                                class="level-opt block w-full text-left px-5 py-3 font-mono text-xs uppercase hover:bg-black hover:text-white transition-colors border-b border-gray-100 last:border-0
                                       {{ ($level ?? 'All') === $l ? 'bg-black text-white' : '' }}">
                            {{ $l }}
                        </button>
                        @endforeach
                    </div>
                </div>

                {{-- ── Search ── --}}
                <div class="p-4 flex-grow flex items-center gap-3">
                    <input id="search-input"
                           type="text"
                           name="search"
                           value="{{ $search ?? '' }}"
                           placeholder="Search courses…"
                           autocomplete="off"
                           class="w-full bg-transparent border-b-2 border-black font-mono text-sm focus:outline-none focus:border-blue-600 placeholder-gray-400 pb-1">
                    <button type="submit"
                            class="brutal-border bg-black text-white font-mono text-xs uppercase px-4 py-2 hover:bg-gray-800 transition-colors flex-shrink-0">
                        Search
                    </button>
                </div>
            </form>
        </div>


        {{-- ── Results meta ─────────────────────────────────────────────────────── --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 flex items-center justify-between">
            <p class="font-mono text-xs text-gray-500 uppercase">
                Showing <span class="font-bold text-black">{{ $courses->count() }}</span> course{{ $courses->count() !== 1 ? 's' : '' }}
                @if(($search ?? '') || ($domain ?? 'All') !== 'All' || ($level ?? 'All') !== 'All')
                    — <a href="{{ route('catalog') }}" class="underline decoration-2 hover:text-blue-600 transition-colors">Clear filters</a>
                @endif
            </p>
        </div>

        {{-- ── Catalog Grid ─────────────────────────────────────────────────────── --}}
        <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                @forelse($courses as $course)
                <a href="{{ route('course', $course->slug) }}"
                   class="brutal-border bg-white flex flex-col brutal-shadow hover-lift group block">

                    {{-- Card thumbnail --}}
                    <div class="h-48 border-b-2 border-black {{ $course->theme_color ?? 'bg-blue-200' }} relative overflow-hidden flex items-center justify-center">
                        @php
                            $decorators = [
                                // Design
                                'uiux101'         => 'checkerboard',
                                'motion-design'   => 'dots',
                                'design-systems'  => 'lines',
                                'typography'      => 'typo',
                                // Development
                                'fsdev'           => 'braces',
                                'reactjs'         => 'hex',
                                'devops'          => 'grid',
                                'api-design'      => 'slash',
                                // Theory
                                'sysarch'         => 'diamond',
                                'algorithms'      => 'zigzag',
                                'ml-foundations'  => 'wave',
                                // Business
                                'bizmgmt'         => 'circle',
                                'marketing'       => 'radial',
                                'finance'         => 'bars',
                                'product-mgmt'    => 'arrows',
                                'leadership'      => 'cross',
                                // Data Science
                                'python-ds'       => 'snake',
                                'deep-learning'   => 'neural',
                                'data-viz'        => 'scatter',
                                'sql-analytics'   => 'table',
                                // Cybersecurity
                                'ethical-hacking' => 'lock',
                                'network-security'=> 'rings',
                                'cloud-security'  => 'shield',
                                // Science
                                'quantum-computing'=> 'orbit',
                                'biotech'         => 'dna',
                                // Health & Wellness
                                'sports-science'  => 'pulse',
                                'nutrition'       => 'leaf',
                                'mindfulness'     => 'spiral',
                            ];
                            $deco = $decorators[$course->slug] ?? 'default';
                        @endphp

                        @if($deco === 'checkerboard')
                            <div class="absolute inset-0 opacity-30"
                                 style="background-image: repeating-linear-gradient(45deg,#111 25%,transparent 25%,transparent 75%,#111 75%,#111),repeating-linear-gradient(45deg,#111 25%,transparent 25%,transparent 75%,#111 75%,#111);background-position:0 0,10px 10px;background-size:20px 20px;"></div>
                        @elseif($deco === 'circle')
                            <div class="absolute w-full h-full border-4 border-dashed border-black rounded-full scale-150 transform -translate-y-8"></div>
                        @elseif($deco === 'braces')
                            <div class="font-mono text-8xl text-blue-800 opacity-20 absolute -left-4 -bottom-8 font-bold">{ }</div>
                        @elseif($deco === 'radial')
                            <div class="absolute inset-0 opacity-40"
                                 style="background-image: radial-gradient(circle,#111 2px,transparent 2px);background-size:15px 15px;"></div>
                        @elseif($deco === 'diamond')
                            <div class="absolute w-full h-full border-4 border-solid border-black transform rotate-45 scale-150"></div>
                        @elseif($deco === 'dots')
                            <div class="absolute inset-0 opacity-25"
                                 style="background-image:radial-gradient(circle,#111 1.5px,transparent 1.5px);background-size:10px 10px;"></div>
                        @elseif($deco === 'lines')
                            <div class="absolute inset-0 opacity-20"
                                 style="background-image:repeating-linear-gradient(0deg,#111 0px,#111 2px,transparent 2px,transparent 20px);"></div>
                        @elseif($deco === 'typo')
                            <div class="font-mono text-7xl text-black opacity-10 absolute -right-4 bottom-2 font-bold select-none">Aa</div>
                        @elseif($deco === 'hex')
                            <div class="absolute inset-0 opacity-15"
                                 style="background-image:repeating-linear-gradient(60deg,#111 0,#111 1px,transparent 0,transparent 50%),repeating-linear-gradient(120deg,#111 0,#111 1px,transparent 0,transparent 50%);background-size:24px 14px;"></div>
                        @elseif($deco === 'grid')
                            <div class="absolute inset-0 opacity-20"
                                 style="background-image:linear-gradient(#111 1px,transparent 1px),linear-gradient(to right,#111 1px,transparent 1px);background-size:16px 16px;"></div>
                        @elseif($deco === 'slash')
                            <div class="absolute inset-0 opacity-20"
                                 style="background-image:repeating-linear-gradient(135deg,#111 0,#111 1px,transparent 0,transparent 50%);background-size:12px 12px;"></div>
                        @elseif($deco === 'zigzag')
                            <div class="absolute inset-0 opacity-25"
                                 style="background:repeating-linear-gradient(135deg,#111 0 1px,transparent 1px 12px),repeating-linear-gradient(45deg,#111 0 1px,transparent 1px 12px);"></div>
                        @elseif($deco === 'wave')
                            <div class="absolute inset-0 opacity-20"
                                 style="background:repeating-radial-gradient(circle at 50% 50%,transparent 0,transparent 8px,#111 8px,#111 9px);background-size:32px 32px;"></div>
                        @elseif($deco === 'bars')
                            <div class="absolute inset-0 opacity-20"
                                 style="background-image:repeating-linear-gradient(to right,#111 0,#111 6px,transparent 6px,transparent 18px);"></div>
                        @elseif($deco === 'arrows')
                            <div class="absolute inset-0 opacity-15"
                                 style="background-image:repeating-linear-gradient(45deg,#111 0,#111 1px,transparent 1px,transparent 10px),repeating-linear-gradient(-45deg,#111 0,#111 1px,transparent 1px,transparent 10px);background-size:14px 14px;"></div>
                        @elseif($deco === 'cross')
                            <div class="absolute inset-0 opacity-20"
                                 style="background-image:linear-gradient(#111 1px,transparent 1px),linear-gradient(to right,#111 1px,transparent 1px);background-size:24px 24px;"></div>
                        @elseif($deco === 'snake')
                            <div class="font-mono text-8xl text-black opacity-10 absolute -right-2 -bottom-4 font-bold select-none">🐍</div>
                            <div class="absolute inset-0 opacity-15" style="background-image:repeating-linear-gradient(90deg,#111 0,#111 2px,transparent 2px,transparent 20px);background-size:20px 100%;"></div>
                        @elseif($deco === 'neural')
                            <div class="absolute inset-0 opacity-20"
                                 style="background:radial-gradient(circle at 20% 50%,#111 2px,transparent 2px),radial-gradient(circle at 50% 20%,#111 2px,transparent 2px),radial-gradient(circle at 80% 50%,#111 2px,transparent 2px),radial-gradient(circle at 50% 80%,#111 2px,transparent 2px);background-size:40px 40px;"></div>
                        @elseif($deco === 'scatter')
                            <div class="absolute inset-0 opacity-25"
                                 style="background-image:radial-gradient(circle,#111 1px,transparent 1px),radial-gradient(circle,#111 1px,transparent 1px);background-size:13px 17px,22px 11px;background-position:0 0,7px 9px;"></div>
                        @elseif($deco === 'table')
                            <div class="absolute inset-0 opacity-20"
                                 style="background-image:linear-gradient(#111 2px,transparent 2px),linear-gradient(to right,#111 2px,transparent 2px);background-size:30px 20px;"></div>
                        @elseif($deco === 'lock')
                            <div class="font-mono text-8xl opacity-10 absolute top-2 right-2 select-none">🔒</div>
                            <div class="absolute inset-0 opacity-20" style="background-image:repeating-linear-gradient(90deg,#111 0,#111 1px,transparent 1px,transparent 8px);background-size:8px 100%;"></div>
                        @elseif($deco === 'rings')
                            <div class="absolute inset-0 flex items-center justify-center opacity-15">
                                <div class="w-32 h-32 rounded-full border-4 border-black"></div>
                                <div class="absolute w-20 h-20 rounded-full border-4 border-black"></div>
                                <div class="absolute w-10 h-10 rounded-full border-4 border-black"></div>
                            </div>
                        @elseif($deco === 'shield')
                            <div class="absolute inset-0 opacity-20"
                                 style="background:repeating-linear-gradient(60deg,#111 0 1px,transparent 1px 18px),repeating-linear-gradient(-60deg,#111 0 1px,transparent 1px 18px);background-size:18px 18px;"></div>
                        @elseif($deco === 'orbit')
                            <div class="absolute w-40 h-40 rounded-full border-2 border-dashed border-black opacity-30 transform rotate-12"></div>
                            <div class="absolute w-24 h-24 rounded-full border-2 border-black opacity-20 transform -rotate-12"></div>
                        @elseif($deco === 'dna')
                            <div class="absolute inset-0 opacity-20"
                                 style="background:repeating-linear-gradient(135deg,#111 0 1px,transparent 1px 8px),repeating-linear-gradient(45deg,#111 0 1px,transparent 1px 8px);background-size:8px 8px;"></div>
                        @elseif($deco === 'pulse')
                            <div class="absolute inset-0 opacity-20"
                                 style="background-image:url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='20'%3E%3Cpolyline points='0,10 10,10 15,2 20,18 25,10 35,10 40,4 45,16 50,10 80,10' fill='none' stroke='%23111' stroke-width='1.5'/%3E%3C/svg%3E\");background-size:80px 20px;"></div>
                        @elseif($deco === 'leaf')
                            <div class="absolute inset-0 opacity-15"
                                 style="background:repeating-radial-gradient(ellipse at 0% 100%,transparent 0,transparent 10px,#111 10px,#111 11px);background-size:20px 20px;"></div>
                        @elseif($deco === 'spiral')
                            <div class="absolute inset-0 opacity-15"
                                 style="background:repeating-conic-gradient(#111 0deg,#111 1deg,transparent 1deg,transparent 30deg);background-size:40px 40px;"></div>
                        @endif

                        <h2 class="text-6xl font-bold uppercase z-10 text-white" style="-webkit-text-stroke: 2px #111;">
                            {{ strtoupper(substr($course->slug, 0, 4)) }}
                        </h2>
                    </div>

                    {{-- Card body --}}
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="flex justify-between items-start mb-2">
                            <span class="bg-black text-white font-mono text-[10px] uppercase px-2 py-1">{{ $course->domain }}</span>
                            <span class="font-mono text-xs font-bold">{{ $course->duration }}</span>
                        </div>
                        <h3 class="text-2xl font-bold uppercase mb-2 group-hover:text-blue-600 transition-colors">{{ $course->title }}</h3>
                        <p class="font-mono text-sm text-gray-700 mb-6 flex-grow">{{ $course->description }}</p>
                        <div class="border-t-2 border-black pt-4 flex justify-between items-center mt-auto">
                            <span class="font-mono text-sm font-bold uppercase">{{ $course->level }}</span>
                            <span class="font-mono text-sm uppercase underline decoration-2">View Course</span>
                        </div>
                    </div>
                </a>
                @empty
                <div class="col-span-3 text-center py-12 brutal-border bg-white brutal-shadow p-8">
                    <p class="font-mono text-2xl font-bold mb-2">No Results</p>
                    <p class="font-mono text-sm text-gray-500 mb-6">No courses match your search or filter criteria.</p>
                    <a href="{{ route('catalog') }}"
                       class="brutal-border bg-black text-white font-mono text-xs uppercase px-6 py-3 hover:bg-gray-800 transition-colors inline-block">
                        Clear Filters
                    </a>
                </div>
                @endforelse

            </div>
        </div>
    </div>

    <script>
        (function () {
            const form = document.getElementById('filter-form');

            function makeDropdown(btnId, panelId, chevronId, labelId, inputId, optClass, dataKey) {
                const btn     = document.getElementById(btnId);
                const panel   = document.getElementById(panelId);
                const chevron = document.getElementById(chevronId);
                const label   = document.getElementById(labelId);
                const input   = document.getElementById(inputId);

                // Toggle open/close
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const isOpen = !panel.classList.contains('hidden');
                    // Close all panels first
                    document.querySelectorAll('.dd-panel').forEach(p => p.classList.add('hidden'));
                    document.querySelectorAll('.dd-chevron').forEach(c => c.style.transform = '');
                    if (!isOpen) {
                        panel.classList.remove('hidden');
                        chevron.style.transform = 'rotate(180deg)';
                    }
                });

                // Option click
                panel.querySelectorAll('.' + optClass).forEach(function (opt) {
                    opt.addEventListener('click', function () {
                        const val = opt.dataset[dataKey];
                        input.value = val;
                        label.textContent = val;
                        // Update active state
                        panel.querySelectorAll('.' + optClass).forEach(o => {
                            o.classList.remove('bg-black', 'text-white');
                        });
                        opt.classList.add('bg-black', 'text-white');
                        panel.classList.add('hidden');
                        chevron.style.transform = '';
                        form.submit();
                    });
                });

                panel.classList.add('dd-panel');
                chevron.classList.add('dd-chevron');
            }

            makeDropdown('domain-btn', 'domain-panel', 'domain-chevron', 'domain-label', 'input-domain', 'domain-opt', 'domain');
            makeDropdown('level-btn',  'level-panel',  'level-chevron',  'level-label',  'input-level',  'level-opt',  'level');

            // Close all on outside click
            document.addEventListener('click', function () {
                document.querySelectorAll('.dd-panel').forEach(p => p.classList.add('hidden'));
                document.querySelectorAll('.dd-chevron').forEach(c => c.style.transform = '');
            });
        })();
    </script>
@endsection