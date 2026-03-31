<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
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