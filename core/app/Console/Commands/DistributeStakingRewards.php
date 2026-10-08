<?php

namespace App\Console\Commands;

use App\Models\Staking;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Console\Command;
use Carbon\Carbon;

class DistributeStakingRewards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'staking:distribute-rewards';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Distribute daily rewards for active stakings';

    /**
     * Execute the console command.
     */
    public function handle()
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

            $this->info("Distributed reward of $reward TRUMP to user {$user->username}");
        }

        $this->info('Staking rewards distribution completed.');
    }
}
