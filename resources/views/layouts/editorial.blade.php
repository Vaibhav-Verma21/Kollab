<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kollab - Learning Platform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;700&family=Space+Mono:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Space Grotesk', sans-serif;
            background-color: #f4f3ef; /* Off-white editorial paper feel */
            color: #111;
        }
        .font-mono {
            font-family: 'Space Mono', monospace;
        }
        .brutal-border {
            border: 2px solid #111;
        }
        .brutal-shadow {
            box-shadow: 4px 4px 0px 0px #111;
        }
        .brutal-shadow-sm {
            box-shadow: 2px 2px 0px 0px #111;
        }
        .hover-lift {
            transition: transform 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.2s ease;
        }
        .hover-lift:hover {
            transform: translate(-2px, -2px);
            box-shadow: 6px 6px 0px 0px #111;
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col selection:bg-yellow-300 selection:text-black">
    <!-- Navbar -->
    <nav class="border-b-2 border-black bg-[#f4f3ef] sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center border-r-2 border-black pr-8">
                    <a href="/" class="text-3xl font-bold tracking-tighter uppercase">Kollab<span class="text-blue-600">.</span></a>
                </div>
                <div class="hidden md:flex items-center space-x-6 px-8 overflow-x-auto">
                    <a href="{{ route('catalog') }}" class="font-mono text-xs uppercase font-bold hover:bg-black hover:text-white px-3 py-1.5 transition-colors border-2 border-transparent hover:border-black">Catalog</a>
                    <a href="{{ route('dashboard') }}" class="font-mono text-xs uppercase font-bold hover:bg-black hover:text-white px-3 py-1.5 transition-colors border-2 border-transparent hover:border-black">Dashboard</a>
                    <a href="{{ route('workspace') }}" class="font-mono text-xs uppercase font-bold hover:bg-black hover:text-white px-3 py-1.5 transition-colors border-2 border-transparent hover:border-black">Workspace</a>
                    <a href="{{ route('forum') }}" class="font-mono text-xs uppercase font-bold hover:bg-black hover:text-white px-3 py-1.5 transition-colors border-2 border-transparent hover:border-black">Forum</a>
                    <a href="{{ route('assignment') }}" class="font-mono text-xs uppercase font-bold hover:bg-black hover:text-white px-3 py-1.5 transition-colors border-2 border-transparent hover:border-black">Assignments</a>
                </div>
                <div class="flex items-center space-x-4 border-l-2 border-black pl-8">
                    @auth
                        <a href="{{ route('profile.edit') }}" class="brutal-border px-4 py-1.5 font-mono text-xs bg-yellow-300 hover:bg-yellow-400 font-bold uppercase brutal-shadow-sm hover-lift">Profile</a>
                    @else
                        <a href="{{ route('login') }}" class="font-mono text-xs font-bold uppercase hover:underline">Log in</a>
                        <a href="{{ route('register') }}" class="brutal-border px-4 py-1.5 font-mono text-xs bg-black text-white hover:bg-gray-800 font-bold uppercase brutal-shadow-sm hover-lift">Sign up</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow flex flex-col">
        @yield('content')
    </main>

    @if(!Route::is('workspace'))
    <!-- Footer -->
    <footer class="border-t-2 border-black bg-[#f4f3ef] text-black py-16 mt-auto">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="col-span-2">
                <h2 class="text-4xl font-bold mb-4 tracking-tighter uppercase">Kollab.</h2>
                <p class="font-mono text-sm max-w-md border-l-2 border-black pl-4">The next-generation collaborative learning platform. Designed for real-time interaction and structured learning.</p>
            </div>
            <div>
                <h3 class="font-mono font-bold mb-4 uppercase bg-black text-white inline-block px-2 py-1 text-xs">Platform</h3>
                <ul class="space-y-3 font-mono text-sm font-bold">
                    <li><a href="#" class="hover:underline hover:text-blue-600">Catalog</a></li>
                    <li><a href="#" class="hover:underline hover:text-blue-600">Workspaces</a></li>
                    <li><a href="#" class="hover:underline hover:text-blue-600">Forums</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-mono font-bold mb-4 uppercase bg-black text-white inline-block px-2 py-1 text-xs">Legal</h3>
                <ul class="space-y-3 font-mono text-sm font-bold">
                    <li><a href="#" class="hover:underline hover:text-blue-600">Privacy Policy</a></li>
                    <li><a href="#" class="hover:underline hover:text-blue-600">Terms of Service</a></li>
                </ul>
            </div>
        </div>
    </footer>
    @endif
</body>
</html>
