<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Staking;
use App\Models\Transaction;
use Illuminate\Http\Request;

class StakingController extends Controller
{
    public function index()
    {
        $pageTitle = 'Staking';
        $user = auth()->user();
        $stakings = Staking::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(getPaginate());
        
        return view('Template::user.staking.index', compact('pageTitle', 'stakings','user'));
    }

    public function stake(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|gt:0',
        ]);

        $user = auth()->user();

        if ($user->coin_balance < $request->amount) {
            $notify[] = ['error', 'Insufficient coin balance'];
            return back()->withNotify($notify);
        }

        // Deduct from coin_balance and add to staked_balance
        $user->coin_balance -= $request->amount;
        $user->staked_balance += $request->amount;
        $user->save();

        // Create staking record
        $staking = new Staking();
        $staking->user_id = $user->id;
        $staking->amount = $request->amount;
        $staking->daily_reward = ($request->amount * 4) / 100; // 4% daily
        $staking->status = 1; // Active
        $staking->save();
        
        levelCommission($user, $request->amount, 'plan_subscribe_commission', $trx);

        // Log transaction
        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $request->amount;
        $transaction->post_balance = $user->coin_balance;
        $transaction->charge = 0;
        $transaction->trx_type = '-';
        $transaction->details = 'Staked ' . getAmount($request->amount) . ' TRUMP';
        $transaction->remark = 'staking';
        $transaction->trx = getTrx();
        $transaction->save();

        $notify[] = ['success', 'Amount staked successfully'];
        return back()->withNotify($notify);
    }
}
