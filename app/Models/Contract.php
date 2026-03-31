<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'contract_template_id',
        'capital',
        'currency',
        'entry_fees',
        'investor_share',
        'manager_share',
        'early_withdrawal_penalty',
        'capital_protection',
        'duration_months',
        'status',
        'start_date',
        'end_date',
        'current_capital',
        'profit_loss',
        'client_accepted',
        'accepted_at',
        'pdf_path',
    ];

    protected $casts = [
        'start_date'               => 'datetime',
        'end_date'                 => 'datetime',
        'accepted_at'              => 'datetime',
        'client_accepted'          => 'boolean',
        'capital'                  => 'decimal:2',
        'entry_fees'               => 'decimal:2',
        'investor_share'           => 'decimal:2',
        'manager_share'            => 'decimal:2',
        'early_withdrawal_penalty' => 'decimal:2',
        'capital_protection'       => 'decimal:2',
        'current_capital'          => 'decimal:2',
        'profit_loss'              => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function template()
    {
        return $this->belongsTo(ContractTemplate::class, 'contract_template_id');
    }

    public function profitPercentage(): float
    {
        if (!$this->capital || $this->capital == 0) return 0;
        return ($this->profit_loss / $this->capital) * 100;
    }

    public function investorProfit(): float
    {
        if ($this->profit_loss <= 0) return 0;
        return $this->profit_loss * ($this->investor_share / 100);
    }

    public function managerProfit(): float
    {
        if ($this->profit_loss <= 0) return 0;
        return $this->profit_loss * ($this->manager_share / 100);
    }
}