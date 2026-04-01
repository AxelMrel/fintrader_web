@extends('admin.layout')
@section('page-title', 'Tableau de bord')
@section('page-subtitle', 'Vue d\'ensemble de la plateforme')

@section('content')

{{-- Welcome Banner --}}
<div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-yellow-500/20 via-yellow-500/5 to-transparent border border-yellow-500/20 p-8">
    <div class="absolute top-0 right-0 w-64 h-64 bg-yellow-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4"></div>
    <div class="absolute bottom-0 left-1/3 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl translate-y-1/2"></div>
    <div class="relative z-10 flex items-center justify-between">
        <div>
            <p class="text-yellow-500/80 text-xs font-bold uppercase tracking-[0.25em] mb-2">Bienvenue</p>
            <h1 class="text-4xl font-black text-white tracking-tight leading-none">FINTRADER</h1>
            <p class="text-slate-400 text-sm mt-2">{{ now()->translatedFormat('l d F Y') }}</p>
        </div>
        <div class="hidden lg:flex items-center gap-8">
            <div class="text-center">
                <p class="text-5xl font-black text-white">{{ $stats['total_users'] }}</p>
                <p class="text-slate-400 text-xs uppercase tracking-widest mt-1">Clients</p>
            </div>
            <div class="w-px h-12 bg-white/10"></div>
            <div class="text-center">
                <p class="text-5xl font-black text-yellow-400">{{ $stats['active_subscriptions'] }}</p>
                <p class="text-slate-400 text-xs uppercase tracking-widest mt-1">Abonnements</p>
            </div>
            <div class="w-px h-12 bg-white/10"></div>
            <div class="text-center">
                <p class="text-5xl font-black text-white">{{ $stats['total_contracts'] }}</p>
                <p class="text-slate-400 text-xs uppercase tracking-widest mt-1">Contrats</p>
            </div>
        </div>
    </div>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

    {{-- Clients --}}
    <div class="glass-card group relative overflow-hidden rounded-2xl p-6 border border-white/10 bg-white/5 backdrop-blur-xl hover:border-blue-500/30 hover:bg-white/[0.07] transition-all duration-300">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-5">
                <div class="w-11 h-11 bg-blue-500/15 border border-blue-500/20 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <span class="text-[10px] font-bold text-blue-400 bg-blue-400/10 border border-blue-400/20 px-2.5 py-1 rounded-full uppercase tracking-wider">Clients</span>
            </div>
            <p class="text-4xl font-black text-white tracking-tight">{{ $stats['total_users'] }}</p>
            <p class="text-slate-500 text-xs mt-1.5 font-medium">Clients inscrits</p>
            <div class="mt-4 h-1 bg-white/5 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-blue-500 to-blue-400 rounded-full" style="width: 72%"></div>
            </div>
        </div>
    </div>

    {{-- Signaux --}}
    <div class="glass-card group relative overflow-hidden rounded-2xl p-6 border border-white/10 bg-white/5 backdrop-blur-xl hover:border-yellow-500/30 hover:bg-white/[0.07] transition-all duration-300">
        <div class="absolute inset-0 bg-gradient-to-br from-yellow-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-5">
                <div class="w-11 h-11 bg-yellow-500/15 border border-yellow-500/20 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <span class="text-[10px] font-bold text-yellow-400 bg-yellow-400/10 border border-yellow-400/20 px-2.5 py-1 rounded-full uppercase tracking-wider">{{ $stats['active_signals'] }} actifs</span>
            </div>
            <p class="text-4xl font-black text-white tracking-tight">{{ $stats['total_signals'] }}</p>
            <p class="text-slate-500 text-xs mt-1.5 font-medium">Signaux publiés</p>
            <div class="mt-4 h-1 bg-white/5 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-yellow-500 to-yellow-400 rounded-full" style="width: 58%"></div>
            </div>
        </div>
    </div>

    {{-- Contrats --}}
    <div class="glass-card group relative overflow-hidden rounded-2xl p-6 border border-white/10 bg-white/5 backdrop-blur-xl hover:border-emerald-500/30 hover:bg-white/[0.07] transition-all duration-300">
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-5">
                <div class="w-11 h-11 bg-emerald-500/15 border border-emerald-500/20 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <span class="text-[10px] font-bold text-emerald-400 bg-emerald-400/10 border border-emerald-400/20 px-2.5 py-1 rounded-full uppercase tracking-wider">{{ $stats['pending_contracts'] }} en attente</span>
            </div>
            <p class="text-4xl font-black text-white tracking-tight">{{ $stats['total_contracts'] }}</p>
            <p class="text-slate-500 text-xs mt-1.5 font-medium">Contrats total</p>
            <div class="mt-4 h-1 bg-white/5 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-emerald-500 to-emerald-400 rounded-full" style="width: 85%"></div>
            </div>
        </div>
    </div>

    {{-- Abonnements --}}
    <div class="glass-card group relative overflow-hidden rounded-2xl p-6 border border-white/10 bg-white/5 backdrop-blur-xl hover:border-purple-500/30 hover:bg-white/[0.07] transition-all duration-300">
        <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-5">
                <div class="w-11 h-11 bg-purple-500/15 border border-purple-500/20 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                    </svg>
                </div>
                <span class="text-[10px] font-bold text-purple-400 bg-purple-400/10 border border-purple-400/20 px-2.5 py-1 rounded-full uppercase tracking-wider">Actifs</span>
            </div>
            <p class="text-4xl font-black text-white tracking-tight">{{ $stats['active_subscriptions'] }}</p>
            <p class="text-slate-500 text-xs mt-1.5 font-medium">Abonnements actifs</p>
            <div class="mt-4 h-1 bg-white/5 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-purple-500 to-purple-400 rounded-full" style="width: 45%"></div>
            </div>
        </div>
    </div>
</div>

{{-- Alerte contrats en attente --}}
@if($stats['pending_contracts'] > 0)
<div class="mb-6 rounded-2xl border border-yellow-500/20 bg-yellow-500/[0.07] backdrop-blur-md p-4 flex items-center gap-4">
    <div class="w-9 h-9 bg-yellow-500/20 rounded-xl flex items-center justify-center shrink-0">
        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
        </svg>
    </div>
    <p class="text-yellow-200/80 text-sm font-medium flex-1">
        <span class="text-yellow-400 font-bold">{{ $stats['pending_contracts'] }} contrat(s)</span> en attente de validation.
    </p>
    <a href="{{ route('admin.contracts.index') }}" class="text-xs font-bold text-yellow-400 bg-yellow-500/15 border border-yellow-500/20 px-4 py-2 rounded-xl hover:bg-yellow-500/25 transition-colors whitespace-nowrap">
        Voir les contrats →
    </a>
</div>
@endif

{{-- Tableaux --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Derniers contrats --}}
    <div class="rounded-2xl border border-white/10 bg-white/[0.03] backdrop-blur-xl overflow-hidden">
        <div class="px-6 py-5 border-b border-white/[0.06] flex justify-between items-center bg-white/[0.02]">
            <div class="flex items-center gap-3">
                <div class="w-1.5 h-5 bg-yellow-500 rounded-full"></div>
                <h3 class="font-bold text-white text-sm tracking-wide">Derniers contrats</h3>
            </div>
            <a href="{{ route('admin.contracts.index') }}" class="text-xs font-semibold text-yellow-500/80 hover:text-yellow-400 transition-colors flex items-center gap-1">
                Voir tout
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="divide-y divide-white/[0.04]">
            @forelse($recent_contracts as $contract)
            <div class="px-6 py-4 flex items-center justify-between hover:bg-white/[0.03] transition-colors group">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-yellow-500/20 to-yellow-500/5 border border-yellow-500/20 flex items-center justify-center shrink-0">
                        <span class="text-yellow-400 font-black text-sm">
                            {{ strtoupper(substr($contract->client->first_name, 0, 1)) }}
                        </span>
                    </div>
                    <div>
                        <p class="font-semibold text-white text-sm">
                            {{ $contract->client->first_name }} {{ $contract->client->last_name }}
                        </p>
                        <p class="text-xs text-slate-500 font-medium">{{ number_format($contract->capital, 2) }} {{ $contract->currency }}</p>
                    </div>
                </div>
                <span class="text-[11px] font-bold px-3 py-1.5 rounded-full border
                    {{ $contract->status === 'pending'   ? 'bg-yellow-400/10 border-yellow-400/20 text-yellow-400' : '' }}
                    {{ $contract->status === 'active'    ? 'bg-emerald-400/10 border-emerald-400/20 text-emerald-400' : '' }}
                    {{ $contract->status === 'closed'    ? 'bg-slate-400/10 border-slate-400/20 text-slate-400' : '' }}
                    {{ $contract->status === 'cancelled' ? 'bg-red-400/10 border-red-400/20 text-red-400' : '' }}">
                    {{ ucfirst($contract->status) }}
                </span>
            </div>
            @empty
            <div class="px-6 py-12 text-center">
                <div class="w-12 h-12 bg-white/5 rounded-2xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <p class="text-slate-600 text-sm">Aucun contrat pour le moment</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Derniers clients --}}
    <div class="rounded-2xl border border-white/10 bg-white/[0.03] backdrop-blur-xl overflow-hidden">
        <div class="px-6 py-5 border-b border-white/[0.06] flex justify-between items-center bg-white/[0.02]">
            <div class="flex items-center gap-3">
                <div class="w-1.5 h-5 bg-blue-500 rounded-full"></div>
                <h3 class="font-bold text-white text-sm tracking-wide">Derniers clients</h3>
            </div>
            <a href="{{ route('admin.users.index') }}" class="text-xs font-semibold text-blue-400/80 hover:text-blue-400 transition-colors flex items-center gap-1">
                Voir tout
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="divide-y divide-white/[0.04]">
            @forelse($recent_users as $user)
            <div class="px-6 py-4 flex items-center gap-3 hover:bg-white/[0.03] transition-colors">
                <div class="w-9 h-9 bg-gradient-to-br from-blue-500/20 to-purple-500/20 border border-white/10 rounded-full flex items-center justify-center shrink-0">
                    <span class="text-white font-bold text-xs">
                        {{ strtoupper(substr($user->first_name, 0, 1)) }}
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-white text-sm truncate">
                        {{ $user->first_name }} {{ $user->last_name }}
                    </p>
                    <p class="text-xs text-slate-500 truncate">{{ $user->email }}</p>
                </div>
                <span class="text-[11px] text-slate-600 bg-white/[0.04] border border-white/[0.06] px-2.5 py-1 rounded-full shrink-0 font-medium">
                    {{ $user->created_at->diffForHumans() }}
                </span>
            </div>
            @empty
            <div class="px-6 py-12 text-center">
                <div class="w-12 h-12 bg-white/5 rounded-2xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <p class="text-slate-600 text-sm">Aucun client pour le moment</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

@endsection