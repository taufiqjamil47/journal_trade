<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Account;

class SetSelectedAccount
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Jika ada query parameter account_id, set ke session
        if ($request->has('account_id')) {
            $accountId = $request->query('account_id');
            if (Account::where('id', $accountId)->exists()) {
                session(['selected_account_id' => $accountId]);
            }
        }

        // Jika session belum ada selected account, gunakan account pertama
        if (!session()->has('selected_account_id')) {
            $firstAccount = Account::first();
            if ($firstAccount) {
                session(['selected_account_id' => $firstAccount->id]);
            }
        }

        // Pass selected account ke view
        view()->share([
            'selectedAccount' => Account::find(session('selected_account_id')),
            'allAccounts' => Account::all(),
        ]);

        return $next($request);
    }
}
