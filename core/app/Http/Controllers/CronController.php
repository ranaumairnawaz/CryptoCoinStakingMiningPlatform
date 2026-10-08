<?php

namespace App\Http\Controllers;

use App\Models\Staking;
use App\Models\Transaction;
use Carbon\Carbon;

class CronController extends Controller
{
    public function staking()
    {
        $stakings = Staking::where('status', 1)
            ->where(function ($query) {
                $query->whereNull('last_reward_at')
                      ->orWhere('last_reward_at', '<=', Carbon::now()->subDay());
            })
            ->get();

        foreach ($stakings as $staking) {
            $user = $staking->user;
            $reward = $staking->daily_reward;

            // Add reward to user's coin balance
            $user->coin_balance += $reward;
            $user->save();

            // Update staking record
            $staking->last_reward_at = Carbon::now();
            $staking->save();

            // Log transaction
            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = $reward;
            $transaction->post_balance = $user->coin_balance;
            $transaction->charge = 0;
            $transaction->trx_type = '+';
            $transaction->details = 'Staking Reward for ' . getAmount($staking->amount) . ' TRUMP';
            $transaction->remark = 'staking_reward';
            $transaction->trx = getTrx();
            $transaction->save();
        }

        return 'Staking rewards distribution completed.';
    }
}
