<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferralCommission extends Model
{
    protected $fillable = [
        'beneficiary_id',
        'source_user_id',
        'contract_id',
        'amount',
        'percentage',
        'level',
    ];

    protected $casts = [
        'amount'     => 'decimal:2',
        'percentage' => 'decimal:2',
    ];

    public function beneficiary()
    {
        return $this->belongsTo(User::class, 'beneficiary_id');
    }

    public function sourceUser()
    {
        return $this->belongsTo(User::class, 'source_user_id');
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}