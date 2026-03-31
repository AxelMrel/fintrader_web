<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'entry_fees',
        'duration_months',
        'investor_share',
        'manager_share',
        'early_withdrawal_penalty',
        'capital_protection',
        'min_capital',
        'max_capital',
        'currency',
        'is_active',
        'terms',
    ];

    protected $casts = [
        'is_active'                 => 'boolean',
        'entry_fees'                => 'decimal:2',
        'investor_share'            => 'decimal:2',
        'manager_share'             => 'decimal:2',
        'early_withdrawal_penalty'  => 'decimal:2',
        'capital_protection'        => 'decimal:2',
        'min_capital'               => 'decimal:2',
        'max_capital'               => 'decimal:2',
    ];

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}