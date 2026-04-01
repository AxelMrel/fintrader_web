<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Plan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $query = Subscription::with(['user', 'plan'])->latest();

        if ($request->status && $request->status !== 'tous') {
            $query->where('status', $request->status);
        }

        $subscriptions = $query->get();

        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    public function create()
    {
        $users = User::orderBy('first_name')->get();
        $plans = Plan::orderBy('name')->get();

        return view('admin.subscriptions.create', compact('users', 'plans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'plan_id' => 'required|exists:plans,id',
            'status'  => 'required|in:pending,active,expired,cancelled',
        ]);

        $startDate = $request->status === 'active' ? now() : null;
        $endDate   = $request->status === 'active' ? Carbon::now()->addMonth() : null;

        Subscription::create([
            'user_id'    => $request->user_id,
            'plan_id'    => $request->plan_id,
            'status'     => $request->status,
            'start_date' => $startDate,
            'end_date'   => $endDate,
        ]);

        return redirect()
            ->route('admin.subscriptions.index')
            ->with('success', 'Abonnement créé avec succès !');
    }

    public function activate(Subscription $subscription)
    {
        $subscription->update([
            'status'     => 'active',
            'start_date' => now(),
            'end_date'   => Carbon::now()->addMonth(),
        ]);

        return redirect()
            ->route('admin.subscriptions.index')
            ->with('success', 'Abonnement activé avec succès !');
    }
}