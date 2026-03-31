<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signal extends Model
{
    use HasFactory;

    protected $fillable = [
        'trader_id',
        'pair',
        'direction',
        'entry_price',
        'take_profit',
        'stop_loss',
        'description',
        'status',
        'plan_required',
    ];

    public function trader()
    {
        return $this->belongsTo(User::class, 'trader_id');
    }
}