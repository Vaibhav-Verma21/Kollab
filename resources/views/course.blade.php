@extends('layouts.editorial')

@section('content')
<div x-data="{ notesOpen: true }" class="flex-grow flex flex-col md:flex-row h-full">
    
    <!-- Main Video Area -->
    <div :class="notesOpen ? 'w-full md:w-2/3 lg:w-3/4' : 'w-full'" class="flex flex-col transition-all duration-300 border-r-2 border-black bg-gray-100 flex-grow">
        <!-- Video Header -->
        <div class="p-4 border-b-2 border-black flex justify-between items-center bg-white">
            <div>
                <h1 class="text-2xl font-bold uppercase tracking-tighter">Course View: <span class="text-blue-600">{{ $course->title }}</span></h1>
                <p class="font-mono text-xs mt-1">{{ $course->domain }} &bull; {{ $course->level }}</p>
            </div>
            <button @click="notesOpen = !notesOpen" class="brutal-border bg-yellow-300 hover:bg-yellow-400 px-4 py-2 font-mono text-xs uppercase font-bold brutal-shadow-sm hover-lift transition-transform">
                <span x-text="notesOpen ? 'Close Notes' : 'Open Notes'"></span>
            </button>
        </div>

        <!-- Video Player Container -->
        <div class="flex-grow p-4 md:p-8 flex items-center justify-center bg-[#111]">
            <div class="w-full max-w-5xl aspect-video border-4 border-white shadow-[8px_8px_0px_0px_rgba(255,255,255,0.2)] relative">
                <!-- Embedded YouTube Video -->
                <iframe class="absolute top-0 left-0 w-full h-full" src="{{ $course->video_url ?? 'https://www.youtube.com/embed/dQw4w9WgXcQ' }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
        </div>
        
        <!-- Video Details -->
        <div class="p-6 bg-white border-t-2 border-black md:min-h-48 flex justify-between items-start">
            <div>
                <h2 class="text-xl font-bold uppercase mb-2">Lesson Description</h2>
                <p class="font-mono text-sm mb-4">{{ $course->description }}</p>
                
                <div class="flex space-x-2">
                    <span class="bg-black text-white font-mono text-[10px] uppercase px-2 py-1">{{ $course->level }}</span>
                    <span class="bg-gray-200 text-black font-mono text-[10px] uppercase px-2 py-1 border border-black">{{ $course->duration }}</span>
                </div>
            </div>
            
            @auth
                @if(in_array($course->id, auth()->user()->enrolled_courses ?? []))
                    <div class="brutal-border bg-green-400 px-4 py-2 font-mono text-sm font-bold uppercase text-black brutal-shadow-sm pointer-events-none">
                        Enrolled
                    </div>
                @else
                    <form action="{{ route('enroll.store', $course->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="brutal-border bg-yellow-300 hover:bg-yellow-400 px-4 py-2 font-mono text-sm font-bold uppercase text-black brutal-shadow-sm hover-lift transition-transform">
                            Enroll Now
                        </button>
                    </form>
                @endif
            @endauth
        </div>
    </div>

    <!-- Notes Panel (Collapsible) -->
    <div x-show="notesOpen" 
         x-transition:enter="transition ease-out duration-300" 
         x-transition:enter-start="translate-x-full" 
         x-transition:enter-end="translate-x-0" 
         x-transition:leave="transition ease-in duration-300" 
         x-transition:leave-start="translate-x-0" 
         x-transition:leave-end="translate-x-full" 
         class="w-full md:w-1/3 lg:w-1/4 bg-[#f4f3ef] flex flex-col border-t-2 md:border-t-0 border-black flex-grow">
        
        <div class="p-4 border-b-2 border-black bg-blue-600 text-white flex justify-between items-center">
            <h2 class="font-bold uppercase tracking-tighter text-lg">My Notes</h2>
            @auth
                <span class="font-mono text-[10px] bg-black px-2 py-1">MongoDB Connected</span>
            @else
                <span class="font-mono text-[10px] bg-red-600 px-2 py-1">Offline</span>
            @endauth
        </div>
        
        <div class="flex-grow p-4 flex flex-col relative h-full min-h-[400px]">
            @auth
                <textarea id="notes-textarea" class="w-full flex-grow bg-white border-2 border-black p-4 font-mono text-sm focus:outline-none focus:border-blue-600 resize-none brutal-shadow-sm mb-4" placeholder="Start typing your notes here... They will be saved to your private workspace in MongoDB automatically.">{{ $noteContent }}</textarea>
                
                <div class="flex justify-between items-center">
                    <button id="save-btn" class="brutal-border bg-black text-white px-4 py-2 font-mono text-xs uppercase font-bold hover:bg-gray-800 hover-lift">Save to DB</button>
                    <span class="font-mono text-xs text-green-600 font-bold opacity-0 transition-opacity" id="save-status">Saved!</span>
                </div>
            @else
                <div class="flex-grow flex flex-col items-center justify-center text-center p-6 bg-white border-2 border-dashed border-black brutal-shadow-sm">
                    <p class="font-mono text-sm text-gray-600 mb-4">You must be logged in to save notes to MongoDB.</p>
                    <a href="{{ route('login') }}" class="brutal-border bg-yellow-300 hover:bg-yellow-400 px-6 py-2 font-mono text-xs uppercase font-bold brutal-shadow-sm hover-lift">Log In</a>
                </div>
            @endauth
        </div>
    </div>
    
</div>

<!-- Include Alpine.js -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

@auth
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const saveBtn = document.getElementById('save-btn');
        const textarea = document.getElementById('notes-textarea');
        const status = document.getElementById('save-status');

        if (saveBtn && textarea) {
            saveBtn.addEventListener('click', () => {
                status.textContent = 'Saving...';
                status.classList.remove('opacity-0', 'text-green-600', 'text-red-600');
                status.classList.add('text-gray-500');

                fetch('{{ route("notes.save") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        course_id: '{{ $course->id }}',
                        content: textarea.value
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        status.textContent = 'Saved!';
                        status.classList.remove('text-gray-500');
                        status.classList.add('text-green-600');
                        setTimeout(() => status.classList.add('opacity-0'), 2000);
                    } else {
                        status.textContent = 'Error saving.';
                        status.classList.remove('text-gray-500');
                        status.classList.add('text-red-600');
                    }
                })
                .catch(err => {
                    status.textContent = 'Connection error.';
                    status.classList.remove('text-gray-500');
                    status.classList.add('text-red-600');
                });
            });
        }
    });
</script>
@endauth

@endsection
