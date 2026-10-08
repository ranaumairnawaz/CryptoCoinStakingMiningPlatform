<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Coin;
use App\Models\Conversion;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ConversionController extends Controller
{
    public function index()
    {
        $pageTitle = 'Convert Currency';
        $coin = Coin::where('symbol', 'TRUMP')->first();
        $conversions = Conversion::where('user_id', auth()->id())->orderBy('id', 'desc')->paginate(getPaginate());
        $user = auth()->user();
        return view('Template::user.convert.index', compact('pageTitle', 'coin', 'conversions', 'user'));
    }

    public function convert(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|gt:0',
            'type' => 'required|in:usdt_to_coin,coin_to_usdt',
        ]);

        $user = auth()->user();
        $coin = Coin::where('symbol', 'TRUMP')->first();
        $rate = $coin->rate;

        if ($request->type == 'usdt_to_coin') {
            if ($user->balance < $request->amount) {
                $notify[] = ['error', 'Insufficient USDT balance'];
                return back()->withNotify($notify);
            }

            $coinAmount = $request->amount / $rate;

            $user->balance -= $request->amount;
            $user->coin_balance += $coinAmount;
            $user->save();

            // Log Transaction for USDT
            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = $request->amount;
            $transaction->post_balance = $user->balance;
            $transaction->charge = 0;
            $transaction->trx_type = '-';
            $transaction->details = 'Converted ' . showAmount($request->amount) . ' ' . gs('cur_text') . ' to ' . getAmount($coinAmount) . ' ' . $coin->symbol;
            $transaction->remark = 'conversion';
            $transaction->trx = getTrx();
            $transaction->save();

            // Log Conversion
            $conversion = new Conversion();
            $conversion->user_id = $user->id;
            $conversion->from_currency = gs('cur_text');
            $conversion->to_currency = $coin->symbol;
            $conversion->from_amount = $request->amount;
            $conversion->to_amount = $coinAmount;
            $conversion->rate = $rate;
            $conversion->save();

            $notify[] = ['success', 'Converted successfully'];
        } else {
            if ($user->coin_balance < $request->amount) {
                $notify[] = ['error', 'Insufficient ' . $coin->symbol . ' balance'];
                return back()->withNotify($notify);
            }

            $usdtAmount = $request->amount * $rate;

            $user->coin_balance -= $request->amount;
            $user->balance += $usdtAmount;
            $user->save();

            // Log Transaction for USDT
            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = $usdtAmount;
            $transaction->post_balance = $user->balance;
            $transaction->charge = 0;
            $transaction->trx_type = '+';
            $transaction->details = 'Converted ' . getAmount($request->amount) . ' ' . $coin->symbol . ' to ' . showAmount($usdtAmount) . ' ' . gs('cur_text');
            $transaction->remark = 'conversion';
            $transaction->trx = getTrx();
            $transaction->save();

            // Log Conversion
            $conversion = new Conversion();
            $conversion->user_id = $user->id;
            $conversion->from_currency = $coin->symbol;
            $conversion->to_currency = gs('cur_text');
            $conversion->from_amount = $request->amount;
            $conversion->to_amount = $usdtAmount;
            $conversion->rate = $rate;
            $conversion->save();

            $notify[] = ['success', 'Converted successfully'];
        }

        return back()->withNotify($notify);
    }
}
