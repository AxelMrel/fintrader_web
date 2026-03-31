<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // On récupère tous les utilisateurs triés par les plus récents
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function updatePlan(Request $request, User $user)
    {
        $request->validate([
            'plan' => 'required|in:basic,premium,vip'
        ]);

        $user->update(['plan' => $request->plan]);

        return redirect()->back()->with('success', "Le plan de {$user->name} a été mis à jour.");
    }
}