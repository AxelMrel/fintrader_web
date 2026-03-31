<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ContractController extends Controller
{
    public function index(Request $request)
{
    $query = Contract::with(['client', 'template'])->latest();

    if ($request->status && $request->status !== 'tous') {
        $query->where('status', $request->status);
    }

    $contracts = $query->get();

    return view('admin.contracts.index', compact('contracts'));
}
}