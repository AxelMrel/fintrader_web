@extends('admin.layout')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Publier un nouveau Signal</h2>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
            <p class="font-bold">Succès !</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
            <p class="font-bold">Attention :</p>
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('admin.signals.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Paire (ex: EUR/USD)</label>
                <input type="text" name="pair" value="{{ old('pair') }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="EUR/USD" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Direction</label>
                <select name="direction" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="buy">BUY (Achat)</option>
                    <option value="sell">SELL (Vente)</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 font-bold mb-2 text-sm">Prix d'Entrée</label>
                <input type="number" step="0.00001" name="entry_price" value="{{ old('entry_price') }}" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-gray-700 font-bold mb-2 text-sm">Take Profit</label>
                <input type="number" step="0.00001" name="take_profit" value="{{ old('take_profit') }}" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-gray-700 font-bold mb-2 text-sm">Stop Loss</label>
                <input type="number" step="0.00001" name="stop_loss" value="{{ old('stop_loss') }}" class="w-full border rounded px-3 py-2" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Description / Note (Optionnel)</label>
            <textarea name="description" rows="2" class="w-full border rounded px-3 py-2" placeholder="Ex: Attendre la cassure du support...">{{ old('description') }}</textarea>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Plan requis</label>
            <select name="plan_required" class="w-full border rounded px-3 py-2">
                <option value="basic">Basic (Gratuit)</option>
                <option value="premium">Premium</option>
                <option value="vip">VIP</option>
            </select>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded shadow-lg hover:bg-blue-700 transition duration-200">
            Diffuser le Signal aux Mobiles 🚀
        </button>
    </form>
</div>
@endsection