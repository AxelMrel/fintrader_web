@extends('admin.layout')

@section('page-title', 'Plans')
@section('page-subtitle', 'Gérer les plans d\'abonnement')

@section('content')

<div class="flex justify-between items-center mb-6">
    <div class="flex gap-3">
        @foreach(['tous' => 'Tous', 'active' => 'Actifs', 'inactive' => 'Inactifs'] as $value => $label)
        <a href="{{ request()->fullUrlWithQuery(['filter' => $value]) }}"
           class="px-4 py-2 rounded-lg text-sm font-medium transition
           {{ request('filter', 'tous') === $value
               ? 'bg-purple-500 text-white'
               : 'bg-white/[0.04] text-slate-400 hover:bg-white/[0.08] border border-white/[0.07]' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>
    <a href="{{ route('admin.plans.create') }}"
       class="bg-purple-500 hover:bg-purple-400 text-white text-sm font-bold px-4 py-2 rounded-xl transition shadow-lg shadow-purple-500/20">
        + Nouveau plan
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-5">
    @forelse($plans as $plan)
    <div class="rounded-2xl p-5 flex flex-col gap-4 border
        {{ $plan->type === 'basic'   ? 'border-slate-500/20 bg-slate-500/[0.06]' : '' }}
        {{ $plan->type === 'premium' ? 'border-blue-500/20 bg-blue-500/[0.06]'   : '' }}
        {{ $plan->type === 'vip'     ? 'border-yellow-500/20 bg-yellow-500/[0.06]' : '' }}">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <span class="text-xs font-black uppercase tracking-widest
                {{ $plan->type === 'basic'   ? 'text-slate-400' : '' }}
                {{ $plan->type === 'premium' ? 'text-blue-400'  : '' }}
                {{ $plan->type === 'vip'     ? 'text-yellow-400' : '' }}">
                {{ ucfirst($plan->type) }}
            </span>
            <span class="text-[10px] font-bold px-2.5 py-1 rounded-full
                {{ $plan->is_active ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-red-500/10 text-red-400 border border-red-500/20' }}">
                {{ $plan->is_active ? 'Actif' : 'Inactif' }}
            </span>
        </div>

        {{-- Nom --}}
        <p class="text-white font-black text-lg leading-tight">{{ $plan->name }}</p>

        {{-- Prix --}}
        <div>
            <span class="text-2xl font-black text-white">{{ number_format($plan->price, 0, ',', ' ') }}</span>
            <span class="text-slate-500 text-sm ml-1">FCFA / mois</span>
        </div>

        {{-- Description --}}
        @if($plan->description)
        <p class="text-slate-500 text-sm leading-relaxed">{{ $plan->description }}</p>
        @endif

        {{-- Stats --}}
        <div class="border-t border-white/[0.05] pt-3">
            <p class="text-slate-500 text-xs">
                <span class="text-white font-bold">{{ $plan->subscriptions_count }}</span> souscription(s)
            </p>
        </div>

        {{-- Actions --}}
        <div class="flex gap-2">
            <a href="{{ route('admin.plans.edit', $plan) }}"
               class="flex-1 text-center bg-white/[0.06] hover:bg-white/[0.10] text-slate-300 text-sm font-medium py-2 rounded-xl transition border border-white/[0.07]">
                Modifier
            </a>
            <form action="{{ route('admin.plans.destroy', $plan) }}" method="POST"
                  onsubmit="return confirm('Supprimer ce plan ?')">
                @csrf @method('DELETE')
                <button class="bg-red-500/10 hover:bg-red-500/20 text-red-400 text-sm font-medium px-3 py-2 rounded-xl transition border border-red-500/20">
                    <svg style="width:15px;height:15px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-3 text-center py-16 text-slate-600">
        Aucun plan pour le moment
    </div>
    @endforelse
</div>

@endsection