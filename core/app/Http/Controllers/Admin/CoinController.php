<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coin;
use App\Models\Conversion;
use Illuminate\Http\Request;

class CoinController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Coins';
        $coins = Coin::orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.coin.index', compact('pageTitle', 'coins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:40',
            'symbol' => 'required|string|max:40',
            'rate' => 'required|numeric|gt:0',
        ]);

        $coin = new Coin();
        $coin->name = $request->name;
        $coin->symbol = $request->symbol;
        $coin->rate = $request->rate;
        $coin->save();

        $notify[] = ['success', 'Coin added successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:40',
            'symbol' => 'required|string|max:40',
            'rate' => 'required|numeric|gt:0',
        ]);

        $coin = Coin::findOrFail($id);
        $coin->name = $request->name;
        $coin->symbol = $request->symbol;
        $coin->rate = $request->rate;
        $coin->save();

        $notify[] = ['success', 'Coin updated successfully'];
        return back()->withNotify($notify);
    }

    public function conversions()
    {
        $pageTitle = 'Coin Conversions';
        $conversions = Conversion::with('user')->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.coin.conversions', compact('pageTitle', 'conversions'));
    }
}
