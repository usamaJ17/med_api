<?php 

namespace App\Http\Controllers;

use App\Models\UserWallet;
use Illuminate\Http\Request;

class UserWalletController extends Controller
{
    public function index()
    {
        $wallets = UserWallet::with('user')->get();
        return view('wallets.index', compact('wallets'));
    }

    public function create()
    {
        return view('wallets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'balance' => 'required|numeric|min:0',
        ]);

        UserWallet::create($request->all());
        return redirect()->route('wallets.index')->with('success', 'Wallet created successfully');
    }

    public function show(Wallet $wallet)
    {
        return view('wallets.show', compact('wallet'));
    }

    public function edit(Wallet $wallet)
    {
        return view('wallets.edit', compact('wallet'));
    }

    public function update(Request $request, Wallet $wallet)
    {
        $request->validate([
            'balance' => 'required|numeric|min:0',
        ]);

        $wallet->update($request->only('balance'));
        return redirect()->route('wallets.index')->with('success', 'Wallet updated successfully');
    }

    public function destroy(Wallet $wallet)
    {
        $wallet->delete();
        return redirect()->route('wallets.index')->with('success', 'Wallet deleted successfully');
    }
    public function addBalance(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'balance' => 'required|numeric|min:0',
        ]);
        $wallet = UserWallet::firstOrCreate(
            ['user_id' => $request->patient_id],
            ['balance' => 0]
        );
        $wallet->balance += $request->balance;
        $wallet->save();

        return redirect()->back()->with('success', 'Balance added successfully');
    }


}
