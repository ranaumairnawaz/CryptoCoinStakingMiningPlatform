<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staking;
use App\Models\Transaction;
use Illuminate\Http\Request;

class StakingController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Stakings';
        $stakings = Staking::with('user')->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.staking.index', compact('pageTitle', 'stakings'));
    }

    public function active()
    {
        $pageTitle = 'Active Stakings';
        $stakings = Staking::where('status', 1)->with('user')->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.staking.index', compact('pageTitle', 'stakings'));
    }

    public function completed()
    {
        $pageTitle = 'Completed Stakings';
        $stakings = Staking::where('status', 0)->with('user')->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.staking.index', compact('pageTitle', 'stakings'));
    }

    public function rewardLogs()
    {
        $pageTitle = 'Staking Reward Logs';
        $logs = Transaction::where('remark', 'staking_reward')->with('user')->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.staking.reward_logs', compact('pageTitle', 'logs'));
    }
}
