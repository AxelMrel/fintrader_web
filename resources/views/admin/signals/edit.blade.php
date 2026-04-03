@extends('admin.layout')

@section('page-title', 'Modifier le signal')
@section('page-subtitle', 'Mettre à jour un signal de trading')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm p-8">

        <form action="{{ route('admin.signals.update', $signal->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Paire --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Paire</label>
                <input type="text" name="pair" value="{{ old('pair', $signal->pair) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                @error('pair') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Direction --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Direction</label>
                <select name="direction"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <option value="buy"  {{ old('direction', $signal->direction) == 'buy'  ? 'selected' : '' }}>BUY</option>
                    <option value="sell" {{ old('direction', $signal->direction) == 'sell' ? 'selected' : '' }}>SELL</option>
                </select>
            </div>

            {{-- Prix --}}
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Prix d'entrée</label>
                    <input type="number" step="0.00001" name="entry_price"
                           value="{{ old('entry_price', $signal->entry_price) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Take Profit</label>
                    <input type="number" step="0.00001" name="take_profit"
                           value="{{ old('take_profit', $signal->take_profit) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stop Loss</label>
                    <input type="number" step="0.00001" name="stop_loss"
                           value="{{ old('stop_loss', $signal->stop_loss) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
            </div>

            {{-- Plan --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Plan requis</label>
                <select name="plan_required"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <option value="basic"   {{ old('plan_required', $signal->plan_required) == 'basic'   ? 'selected' : '' }}>Basic</option>
                    <option value="premium" {{ old('plan_required', $signal->plan_required) == 'premium' ? 'selected' : '' }}>Premium</option>
                    <option value="vip"     {{ old('plan_required', $signal->plan_required) == 'vip'     ? 'selected' : '' }}>VIP</option>
                </select>
            </div>

            {{-- Statut --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                <select name="status"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <option value="active"    {{ old('status', $signal->status) == 'active'    ? 'selected' : '' }}>Actif</option>
                    <option value="closed"    {{ old('status', $signal->status) == 'closed'    ? 'selected' : '' }}>Fermé</option>
                    <option value="cancelled" {{ old('status', $signal->status) == 'cancelled' ? 'selected' : '' }}>Annulé</option>
                </select>
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-400">{{ old('description', $signal->description) }}</textarea>
            </div>

            {{-- Boutons --}}
            <div class="flex gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-400 text-slate-900 font-semibold px-6 py-2.5 rounded-lg transition">
                    Mettre à jour
                </button>
                <a href="{{ route('admin.signals.index') }}"
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-6 py-2.5 rounded-lg transition">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection