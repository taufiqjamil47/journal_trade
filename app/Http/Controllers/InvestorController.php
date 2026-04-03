<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Investor;
use Illuminate\Http\Request;

class InvestorController extends Controller
{
    public function store(Request $request, Account $account)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'investment' => 'required|numeric|min:0.01',
            'join_date' => 'nullable|date',
            'note' => 'nullable|string',
        ]);

        $investment = $request->investment;

        // Konversi otomatis jika akun ber-currency USD (input Rp) => USD
        if (strtoupper($account->currency) === 'USD') {
            $idrToUsdRate = config('finance.idr_to_usd_rate', 16000); // dapat diubah di config/finance.php
            $investmentUsd = round($investment / $idrToUsdRate, 2);

            // simpan nilai USD sekaligus note mencatat nilai asli
            $note = trim($request->note ?? '');
            if ($note !== '') {
                $note .= ' | ';
            }
            $note .= "IDR {$investment} dikonversi ke USD {$investmentUsd} (rate {$idrToUsdRate})";

            $investment = $investmentUsd;
            $request->merge(['note' => $note]);
        }

        $account->investors()->create([
            'name' => $request->name,
            'investment' => $investment,
            'join_date' => $request->join_date ?: now()->toDateString(),
            'note' => $request->note,
        ]);

        return redirect()->route('accounts.show', $account)->with('success', 'Investor berhasil ditambahkan');
    }

    public function destroy(Account $account, Investor $investor)
    {
        if ($investor->account_id !== $account->id) {
            abort(403);
        }

        $investor->delete();
        return redirect()->route('accounts.show', $account)->with('success', 'Investor berhasil dihapus');
    }

    public function assignProfitShare(Account $account)
    {
        $totalProfit = $account->trades->sum('profit_loss');
        $totalInvested = $account->totalInvestorInvestment;

        if ($totalInvested <= 0) {
            return redirect()->route('accounts.show', $account)->with('error', 'Tidak ada investasi investor untuk dihitung bagi hasil');
        }

        foreach ($account->investors as $investor) {
            $percentage = $investor->investment / $totalInvested;
            $investor->profit_share = round($percentage * $totalProfit, 2);
            $investor->save();
        }

        return redirect()->route('accounts.show', $account)->with('success', 'Bagi hasil investor berhasil dihitung dan tersimpan');
    }
}
