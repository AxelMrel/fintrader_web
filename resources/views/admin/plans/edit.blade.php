@extends('admin.layout')

@section('page-title', 'Modifier le plan')

@section('content')
<div class="max-w-xl">
    <div class="rounded-2xl p-6 border border-white/[0.07]" style="background: rgba(255,255,255,0.03);">

        @if($errors->any())
        <div class="mb-5 bg-red-500/10 border border-red-500/20 text-red-400 text-sm rounded-xl px-4 py-3">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.plans.update', $plan) }}" method="POST" class="space-y-5">
            @csrf @method('PUT')

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Nom du plan</label>
                <input type="text" name="name" value="{{ old('name', $plan->name) }}"
                    class="w-full bg-white/[0.04] border border-white/[0.08] rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500/50 focus:bg-white/[0.06] transition">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Type</label>
                <select name="type"
                    class="w-full bg-white/[0.04] border border-white/[0.08] rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500/50 transition">
                    @foreach(['basic' => 'Basic', 'premium' => 'Premium', 'vip' => 'VIP'] as $val => $label)
                    <option value="{{ $val }}" {{ old('type', $plan->type) === $val ? 'selected' : '' }}
                        style="background:#0a0f1e">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Prix (FCFA/mois)</label>
                <input type="number" name="price" value="{{ old('price', $plan->price) }}" min="0"
                    class="w-full bg-white/[0.04] border border-white/[0.08] rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500/50 focus:bg-white/[0.06] transition">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Description</label>
                <textarea name="description" rows="3"
                    class="w-full bg-white/[0.04] border border-white/[0.08] rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500/50 focus:bg-white/[0.06] transition resize-none">{{ old('description', $plan->description) }}</textarea>
            </div>

            <div class="flex items-center gap-3">
                <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Actif</label>
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $plan->is_active) ? 'checked' : '' }}
                    class="w-4 h-4 accent-purple-500">
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                    class="bg-purple-500 hover:bg-purple-400 text-white text-sm font-bold px-6 py-2.5 rounded-xl transition shadow-lg shadow-purple-500/20">
                    Enregistrer
                </button>
                <a href="{{ route('admin.plans.index') }}" class="text-sm text-slate-500 hover:text-slate-300 transition">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection