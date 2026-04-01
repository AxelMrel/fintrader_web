<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FINTRADER — Connexion Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<!-- Arrière-plan avec un dégradé et des cercles décoratifs pour accentuer l'effet de verre -->
<body class="bg-[#0f172a] min-h-screen flex items-center justify-center relative overflow-hidden">

    <!-- Formes décoratives en arrière-plan (Optionnel mais recommandé pour le glassmorphism) -->
    <div class="absolute top-[-10%] left-[-10%] w-72 h-72 bg-yellow-500/20 rounded-full blur-[100px]"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-blue-600/20 rounded-full blur-[100px]"></div>

    <div class="w-full max-w-md px-6 z-10">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-yellow-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-yellow-500/20">
                <span class="text-slate-900 font-bold text-4xl">FT</span>
            </div>
            <h1 class="text-white text-3xl font-bold tracking-tight">FINTRADER <span class="text-yellow-500">Admin</span></h1>
            <p class="text-slate-400 text-sm mt-2 font-light">Accédez à votre espace de gestion</p>
        </div>

        {{-- Formulaire Style Glassmorphism --}}
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-2xl">

            @if($errors->any())
            <div class="bg-red-500/20 border border-red-500/50 text-red-200 px-4 py-3 rounded-xl mb-6 text-sm backdrop-blur-md">
                {{ $errors->first() }}
            </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2 ml-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" autofocus
                           class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-yellow-500/50 focus:bg-white/10 transition-all placeholder-slate-500"
                           >
                </div>

                {{-- Mot de passe --}}
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2 ml-1">Mot de passe</label>
                    <input type="password" name="password"
                           class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-yellow-500/50 focus:bg-white/10 transition-all placeholder-slate-500"
                           >
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full bg-yellow-500 hover:bg-yellow-400 text-slate-900 font-bold py-3.5 rounded-xl transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-lg shadow-yellow-500/20 mt-4">
                    Se connecter
                </button>
            </form>
        </div>

        <p class="text-center text-slate-500 text-xs mt-8 uppercase tracking-widest">
            FINTRADER &copy; {{ date('Y') }} — Sécurisé
        </p>
    </div>

</body>
</html>