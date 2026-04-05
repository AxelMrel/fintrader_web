<?php

namespace App\Services;

use App\Models\Contract;
use App\Models\ReferralCommission;
use App\Models\User;
use Illuminate\Support\Str;

class ReferralService
{
    const LEVEL_1_PERCENTAGE = 2.5;
    const LEVEL_2_PERCENTAGE = 2.5;

    // Générer un code unique
    public static function generateCode(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (User::where('referral_code', $code)->exists());

        return $code;
    }

    // Calculer et distribuer les commissions
    public static function distributeCommissions(Contract $contract): void
    {
        $client = $contract->client;

        // Pas de profit = pas de commission
        if ($contract->profit_loss <= 0) return;

        // Calcul du profit du client
        $clientProfit = $contract->profit_loss * ($contract->investor_share / 100);

        // Niveau 1 : parrain direct
        if ($client->referred_by) {
            $parrain = User::find($client->referred_by);
            if ($parrain) {
                $commission1 = $clientProfit * (self::LEVEL_1_PERCENTAGE / 100);

                ReferralCommission::create([
                    'beneficiary_id' => $parrain->id,
                    'source_user_id' => $client->id,
                    'contract_id'    => $contract->id,
                    'amount'         => $commission1,
                    'percentage'     => self::LEVEL_1_PERCENTAGE,
                    'level'          => 1,
                ]);

                $parrain->increment('referral_balance', $commission1);

                // Niveau 2 : grand-parrain
                if ($parrain->referred_by) {
                    $grandParrain = User::find($parrain->referred_by);
                    if ($grandParrain) {
                        $commission2 = $clientProfit * (self::LEVEL_2_PERCENTAGE / 100);

                        ReferralCommission::create([
                            'beneficiary_id' => $grandParrain->id,
                            'source_user_id' => $client->id,
                            'contract_id'    => $contract->id,
                            'amount'         => $commission2,
                            'percentage'     => self::LEVEL_2_PERCENTAGE,
                            'level'          => 2,
                        ]);

                        $grandParrain->increment('referral_balance', $commission2);
                    }
                }
            }
        }
    }
}