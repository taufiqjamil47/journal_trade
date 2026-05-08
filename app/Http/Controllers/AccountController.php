<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{
    /**
     * Menampilkan daftar sumber daya.
     */
    public function index()
    {
        $accounts = Account::paginate(15);
        return view('accounts.index', compact('accounts'));
    }

    /**
     * Tampilkan formulir untuk membuat sumber daya baru.
     */
    public function create()
    {
        return view('accounts.create');
    }

    /**
     * Simpan sumber daya yang baru dibuat dalam penyimpanan.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'initial_balance' => 'required|numeric',
            'currency' => 'required|string',
            'commission_per_lot' => 'nullable|numeric',
            'manager_fee_investment_percent' => 'nullable|numeric|min:0|max:100',
            'manager_fee_profit_percent' => 'nullable|numeric|min:0|max:100',
        ]);

        $account = Account::create($request->all());
        return redirect()->route('accounts.show', $account)->with('success', 'Account created successfully');
    }

    /**
     * Tampilkan sumber daya yang ditentukan.
     */
    public function show(string $id)
    {
        $account = Account::with(['trades.symbol', 'investors'])->findOrFail($id);

        // Debug: Log nilai untuk pengecekan
        Log::info('Account ID: ' . $account->id);
        Log::info('Initial Balance: ' . $account->initial_balance);

        $totalInvestment = $account->investors->sum('investment');
        Log::info('Total Investment: ' . $totalInvestment);

        $totalInvestment = $account->investors->sum('investment');
        $totalProfit = $account->trades->sum('profit_loss');
        $roi = ($account->initial_balance > 0) ? ($totalProfit / $account->initial_balance) * 100 : 0;
        $recommendedInitialBalance = $totalInvestment;
        $initialBalanceMismatch = round($account->initial_balance, 2) !== round($recommendedInitialBalance, 2);

        return view('accounts.show', compact(
            'account',
            'totalInvestment',
            'totalProfit',
            'roi',
            'recommendedInitialBalance',
            'initialBalanceMismatch'
        ));
    }

    /**
     * Tampilkan formulir untuk mengedit sumber daya yang ditentukan.
     */
    public function edit(string $id)
    {
        $account = Account::findOrFail($id);
        return view('accounts.edit', compact('account'));
    }

    /**
     * Perbarui sumber daya yang ditentukan di penyimpanan.
     */
    public function update(Request $request, string $id)
    {
        $account = Account::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'initial_balance' => 'sometimes|numeric',
            'currency' => 'sometimes|string',
            'commission_per_lot' => 'sometimes|numeric',
            'manager_fee_investment_percent' => 'nullable|numeric|min:0|max:100',
            'manager_fee_profit_percent' => 'nullable|numeric|min:0|max:100',
        ]);

        $account->update($request->all());
        return redirect()->route('accounts.show', $account)->with('success', 'Account updated successfully');
    }

    /**
     * Hapus sumber daya yang ditentukan dari penyimpanan.
     */
    public function destroy(string $id)
    {
        $account = Account::findOrFail($id);
        $account->delete();
        return redirect()->route('accounts.index')->with('success', 'Account deleted successfully');
    }

    /**
     * Sinkronisasi initial_balance dengan total modal investor.
     */
    public function syncInitialBalance(string $id)
    {
        $account = Account::with('investors')->findOrFail($id);
        $recommendedInitialBalance = round($account->investors->sum('investment'), 2);

        $account->update(['initial_balance' => $recommendedInitialBalance]);

        return redirect()->route('accounts.show', $account)
            ->with('success', 'Initial balance telah disesuaikan dengan total modal investor.');
    }
}
