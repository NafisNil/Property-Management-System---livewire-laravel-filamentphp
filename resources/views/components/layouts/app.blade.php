<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Property Management' }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        :root{
            --color-primary: #003366; /* Navy Blue (Trust) */
            --color-secondary: #3CB371; /* Medium Sea Green (Growth) */
            --color-accent: #FF4500; /* Orange Red (Action) */
            --color-neutral: #F4F4F4; /* Light Gray / White (Background) */
            --radius: 8px;
        }

        body { background-color: var(--color-neutral); }

        .text-primary { color: var(--color-primary); }
        .bg-primary { background-color: var(--color-primary); }
        .border-primary { border-color: var(--color-primary); }

        .text-secondary { color: var(--color-secondary); }
        .bg-secondary { background-color: var(--color-secondary); }

        .text-accent { color: var(--color-accent); }
        .bg-accent { background-color: var(--color-accent); }

        .btn-primary{ background: var(--color-primary); color: white; padding: .45rem .7rem; border-radius: .45rem; }
        .btn-primary:hover{ opacity: .95 }

        .btn-accent{ background: var(--color-accent); color: white; padding: .45rem .7rem; border-radius: .45rem; }
        .btn-accent:hover{ opacity: .95 }

        .btn-outline-primary{ border: 1px solid var(--color-primary); color: var(--color-primary); padding: .35rem .6rem; border-radius: .45rem; background: white }

        .listing-card{ border-radius: var(--radius); transition: box-shadow .12s ease, transform .12s ease; }
        .listing-card:hover{ box-shadow: 0 8px 20px rgba(0,0,0,.08); transform: translateY(-3px); }

        .muted { color: #6b7280; }
        /* Navbar enhancements */
        nav.nav-enhanced { background: linear-gradient(180deg, #ffffff 0%, #f9fafb 100%); }
        .category-nav { position: relative; }
        .nav-link { position: relative; display: inline-flex; align-items: center; padding: 0.75rem 1rem; font-size: .875rem; font-weight: 600; color: #4b5563; text-wrap: nowrap; transition: color .25s ease; }
        .nav-link:hover { color: var(--color-primary); }
        .nav-link::after { content:""; position:absolute; left:1rem; right:1rem; bottom:0; height:2px; background: var(--color-primary); transform: scaleX(0); transform-origin: left; transition: transform .3s ease; border-radius:2px; }
        .nav-link:hover::after { transform: scaleX(1); }
        .nav-link.active { color: var(--color-primary); }
        .nav-link.active::after { transform: scaleX(1); }
        .top-bar { background: linear-gradient(90deg, var(--color-primary) 0%, var(--color-secondary) 100%); }
        .glass { background: rgba(255,255,255,0.85); backdrop-filter: blur(6px); }
        .search-input { border:1px solid #d1d5db; }
        .search-input:focus { outline:none; box-shadow:0 0 0 3px rgba(0,51,102,.18); border-color: var(--color-primary); }
        .location-input { border:1px solid #d1d5db; }
        .location-input:focus { outline:none; box-shadow:0 0 0 3px rgba(60,179,113,.18); border-color: var(--color-secondary); }
        .nav-shadow { box-shadow:0 4px 12px -2px rgba(0,0,0,0.08); }
    </style>
</head>
<body>
    <nav class="nav-enhanced nav-shadow border-b-4 sticky top-0 z-50 mb-6 py-4" style="border-bottom-color: var(--color-primary);">
        <div class="max-w-full mx-auto px-0">
            <!-- Top Bar -->
            <div class="top-bar text-white px-4 sm:px-6 lg:px-8 ">
                <div class="flex justify-between items-center h-10 text-xs">
                    <div class="flex items-center gap-2">
                        <span class="text-gray-400">3rd party ad content</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <a href="#" class="text-gray-300 hover:text-white transition">Post an ad</a>
                        <a href="#" class="text-gray-300 hover:text-white transition">Sign up</a>
                        <a href="#" class="text-gray-300 hover:text-white transition">Login</a>
                    </div>
                </div>
            </div>

            <!-- Main Navigation Bar -->
            <div class="px-4 sm:px-6 lg:px-8 glass">
                <div class="flex justify-between items-center h-16 gap-4">
                    <!-- Logo -->
                    <div class="flex items-center shrink-0">
                        <a href="/" class="text-2xl font-bold" style="color: var(--color-primary);">PropertyHub</a>
                    </div>

                    <!-- Search Bar -->
                    <div class="hidden md:flex flex-1 max-w-2xl mx-4">
                        <div class="w-full flex gap-2">
                            <div class="flex-1 relative">
                                <input type="text" placeholder="Search PropertyHub" class="search-input w-full px-4 py-2 rounded-l-lg focus:outline-none" >
                                <svg class="absolute right-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" placeholder="United Kingdom" class="location-input px-4 py-2 focus:outline-none">
                            <button class="px-6 py-2 rounded-r-lg text-white font-semibold transition hover:opacity-90" style="background-color: var(--color-secondary);">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Right Actions -->
                    <div class="flex items-center gap-2 sm:gap-3">
                        <button class="p-2 rounded-lg hover:bg-gray-100 transition relative" title="Notifications">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                        <button class="p-2 rounded-lg hover:bg-gray-100 transition" title="Messages">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </button>
                        <button class="p-2 rounded-lg hover:bg-gray-100 transition" title="User Account">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Category Navigation -->
                <div class="category-nav flex items-center border-t border-gray-200 overflow-x-auto">
                    <a href="#" class="nav-link">Cars & Vehicles</a>
                    <a href="#" class="nav-link">For Sale</a>
                    <a href="#" class="nav-link">Services</a>
                    <a href="#" class="nav-link active">Property</a>
                    <a href="#" class="nav-link">Pets</a>
                    <a href="#" class="nav-link">Jobs</a>
                    <a href="#" class="nav-link">Community</a>
                </div>
            </div>
        </div>
    </nav>

    <main>
        {{ $slot }}
    </main>

    <footer class="bg-white border-t mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <p class="text-center text-gray-600 text-sm">© {{ date('Y') }} Property Management. All rights reserved.</p>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
