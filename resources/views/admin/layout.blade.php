<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FINTRADER</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0a0f1e] font-sans antialiased text-slate-200 min-h-screen relative overflow-hidden">

    {{-- Éléments décoratifs d'arrière-plan --}}
    <div class="pointer-events-none fixed inset-0 z-0">
        <div class="absolute top-[-15%] left-[-8%] w-[600px] h-[600px] bg-blue-600/15 rounded-full blur-[140px]"></div>
        <div class="absolute bottom-[-10%] right-[-5%] w-[500px] h-[500px] bg-yellow-500/10 rounded-full blur-[120px]"></div>
        <div class="absolute top-[35%] right-[15%] w-[350px] h-[350px] bg-purple-600/10 rounded-full blur-[110px]"></div>
        <div class="absolute top-[60%] left-[30%] w-[250px] h-[250px] bg-emerald-500/5 rounded-full blur-[100px]"></div>
        {{-- Grain overlay --}}
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=%220 0 256 256%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22noise%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.9%22 numOctaves=%224%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23noise)%22/%3E%3C/svg%3E'); background-size: 200px;"></div>
    </div>

    <div class="flex h-screen overflow-hidden relative z-10">

        {{-- ═══════════════════════════════════════
             SIDEBAR
        ════════════════════════════════════════ --}}
        <aside class="w-[268px] shrink-0 flex flex-col relative"
               style="background: rgba(255,255,255,0.03); backdrop-filter: blur(24px); border-right: 1px solid rgba(255,255,255,0.07);">

            {{-- Logo --}}
            <div class="px-7 py-7 border-b border-white/[0.05]">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-yellow-500 rounded-xl flex items-center justify-center shadow-lg shadow-yellow-500/30 shrink-0">
                        <span class="text-slate-900 font-black text-lg tracking-tight">FT</span>
                    </div>
                    <div>
                        <h1 class="text-white font-black text-lg tracking-tight leading-none">FINTRADER</h1>
                        <span class="text-yellow-500/70 text-[10px] uppercase tracking-[0.25em] font-bold">Admin Panel</span>
                    </div>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-4 py-5 space-y-1 overflow-y-auto custom-scrollbar">

                <p class="text-slate-600 text-[10px] font-black uppercase tracking-[0.2em] px-3 mb-3">Menu Principal</p>

                @php
                    $navItems = [
                        [
                            'route' => '/admin/dashboard',
                            'label' => 'Tableau de bord',
                            'icon'  => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
                            'color' => 'yellow',
                        ],
                        [
                            'route' => '/admin/signals',
                            'label' => 'Signaux',
                            'icon'  => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6',
                            'color' => 'blue',
                        ],
                        [
                            'route'   => 'admin.subscriptions.index',
                            'label'   => 'Abonnements',
                            'icon'    => 'M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z',
                            'color'   => 'purple',
                            'isRoute' => true,
                        ],
                        [
                            'route' => '/admin/contracts',
                            'label' => 'Contrats',
                            'icon'  => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                            'color' => 'emerald',
                        ],
                    ];

                    $colorMap = [
                        'yellow'  => ['active_bg' => 'bg-yellow-500',  'active_text' => 'text-slate-900', 'icon_active' => 'text-slate-900', 'icon_hover' => 'group-hover:text-yellow-400',  'dot' => 'bg-yellow-500'],
                        'blue'    => ['active_bg' => 'bg-blue-500',    'active_text' => 'text-white',     'icon_active' => 'text-white',     'icon_hover' => 'group-hover:text-blue-400',    'dot' => 'bg-blue-500'],
                        'purple'  => ['active_bg' => 'bg-purple-500',  'active_text' => 'text-white',     'icon_active' => 'text-white',     'icon_hover' => 'group-hover:text-purple-400',  'dot' => 'bg-purple-500'],
                        'emerald' => ['active_bg' => 'bg-emerald-500', 'active_text' => 'text-white',     'icon_active' => 'text-white',     'icon_hover' => 'group-hover:text-emerald-400', 'dot' => 'bg-emerald-500'],
                    ];
                @endphp

                @foreach($navItems as $item)
                    @php
                        $url    = isset($item['isRoute']) ? route($item['route']) : $item['route'];
                        $active = request()->is(ltrim($item['route'], '/') . '*')
                               || (isset($item['isRoute']) && request()->routeIs($item['route']));
                        $c      = $colorMap[$item['color']];
                    @endphp

                    <a href="{{ $url }}"
                       class="flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-200 group relative overflow-hidden
                       {{ $active
                            ? $c['active_bg'] . ' ' . $c['active_text'] . ' font-bold shadow-lg'
                            : 'text-slate-500 hover:text-white hover:bg-white/[0.06]' }}">

                        @if($active)
                            <div class="absolute inset-0 opacity-20 bg-gradient-to-r from-white/20 to-transparent rounded-xl"></div>
                        @endif

                        <svg class="w-4.5 h-4.5 shrink-0 relative z-10
                             {{ $active ? $c['icon_active'] : 'text-slate-600 ' . $c['icon_hover'] }}
                             transition-colors duration-200"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                        </svg>

                        <span class="text-sm relative z-10">{{ $item['label'] }}</span>

                        @if($active)
                            <div class="ml-auto w-1.5 h-1.5 {{ $c['dot'] }} rounded-full relative z-10"></div>
                        @endif
                    </a>
                @endforeach

                {{-- Séparateur --}}
                <div class="mx-3 my-4 border-t border-white/[0.05]"></div>
                <p class="text-slate-600 text-[10px] font-black uppercase tracking-[0.2em] px-3 mb-3">Gestion</p>

                {{-- Utilisateurs --}}
                @php $usersActive = request()->is('admin/users*'); @endphp
                <a href="/admin/users"
                   class="flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-200 group
                   {{ $usersActive
                        ? 'bg-blue-500/10 text-blue-400 border border-blue-500/20 font-semibold'
                        : 'text-slate-500 hover:text-white hover:bg-white/[0.06]' }}">
                    <svg class="shrink-0 {{ $usersActive ? 'text-blue-400' : 'text-slate-600 group-hover:text-blue-400' }} transition-colors"
                         style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span class="text-sm">Utilisateurs</span>
                    @if($usersActive)
                        <div class="ml-auto w-1.5 h-1.5 bg-blue-400 rounded-full"></div>
                    @endif
                </a>
            </nav>

            {{-- User info bas --}}
            <div class="p-4 border-t border-white/[0.05]">
                <div class="rounded-2xl p-3.5 flex items-center gap-3"
                     style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.07);">
                    <div class="w-9 h-9 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center shadow-inner shrink-0">
                        <span class="text-slate-900 font-black text-sm">A</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-white text-xs font-bold truncate">Administrateur</p>
                        <p class="text-slate-600 text-[10px] truncate">admin@mytrade.com</p>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button title="Déconnexion"
                                class="w-8 h-8 flex items-center justify-center text-slate-600 hover:text-red-400 hover:bg-red-400/10 rounded-xl transition-all duration-200">
                            <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- ═══════════════════════════════════════
             MAIN CONTENT
        ════════════════════════════════════════ --}}
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- HEADER --}}
            <header class="h-[72px] shrink-0 px-8 flex items-center justify-between"
                    style="background: rgba(255,255,255,0.02); backdrop-filter: blur(16px); border-bottom: 1px solid rgba(255,255,255,0.06);">

                {{-- Breadcrumb + titre --}}
                <div>
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="text-slate-600 text-xs">FINTRADER</span>
                        <svg class="w-3 h-3 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                        <span class="text-slate-400 text-xs">@yield('page-title', 'Tableau de bord')</span>
                    </div>
                    <h2 class="text-base font-black text-white tracking-tight leading-none">@yield('page-title', 'Tableau de bord')</h2>
                </div>

                <div class="flex items-center gap-3">
                    {{-- Date pill --}}
                    <div class="hidden md:flex items-center gap-2.5 bg-white/[0.04] border border-white/[0.07] rounded-xl px-4 py-2">
                        <div class="w-1.5 h-1.5 bg-yellow-500 rounded-full animate-pulse"></div>
                        <div>
                            <span class="text-white text-xs font-bold">{{ now()->translatedFormat('d F Y') }}</span>
                            <span class="text-yellow-500/70 text-[10px] uppercase tracking-widest font-semibold ml-2">Live</span>
                        </div>
                    </div>

                    {{-- Notifications --}}
                    <button class="relative w-9 h-9 flex items-center justify-center bg-white/[0.04] border border-white/[0.07] rounded-xl text-slate-400 hover:text-white hover:bg-white/[0.08] transition-all duration-200">
                        <svg style="width:17px;height:17px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-yellow-500 rounded-full border-2 border-[#0a0f1e]"></span>
                    </button>

                    {{-- Avatar admin --}}
                    <div class="w-9 h-9 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center shadow-lg shadow-yellow-500/20">
                        <span class="text-slate-900 font-black text-sm">A</span>
                    </div>
                </div>
            </header>

            {{-- Alertes --}}
            @if(session('success'))
            <div class="mx-8 mt-5">
                <div class="rounded-2xl border border-emerald-500/20 bg-emerald-500/[0.07] backdrop-blur-md px-5 py-3.5 flex items-center gap-3 animate-fade-in-down">
                    <div class="w-8 h-8 bg-emerald-500/20 rounded-xl flex items-center justify-center shrink-0">
                        <svg style="width:15px;height:15px" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="text-emerald-400">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="text-emerald-300 text-sm font-medium">{{ session('success') }}</span>
                </div>
            </div>
            @endif

            {{-- PAGE CONTENT --}}
            <main class="flex-1 overflow-x-hidden overflow-y-auto px-8 py-7 custom-scrollbar">
                @yield('content')
            </main>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar       { width: 3px; }
        .custom-scrollbar::-webkit-scrollbar-track  { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb  { background: rgba(255,255,255,0.08); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.15); }

        @keyframes fade-in-down {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-down { animation: fade-in-down 0.35s ease-out; }
    </style>
</body>
</html>