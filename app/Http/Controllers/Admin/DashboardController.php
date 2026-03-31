<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Signal;
use App\Models\Contract;
use App\Models\Subscription;

class DashboardController extends Controller
{
   public function index()
{
    $stats = [
        // On enlève le filtre 'role' pour compter TOUT le monde (les 2 utilisateurs)
        'total_users'         => User::count(), 
        'total_signals'       => Signal::count(),
        'active_signals'      => Signal::where('status', 'active')->count(),
        'total_contracts'     => Contract::count(),
        'pending_contracts'   => Contract::where('status', 'pending')->count(),
        'active_contracts'    => Contract::where('status', 'active')->count(),
        'active_subscriptions'=> Subscription::where('status', 'active')->count(),
    ];

    $recent_contracts = Contract::with('client')
        ->latest()
        ->take(5)
        ->get();

    // On récupère tout le monde, classé par le plus récent
    $recent_users = User::latest()->get(); 

    return view('admin.dashboard.index', compact('stats', 'recent_contracts', 'recent_users'));
}
}