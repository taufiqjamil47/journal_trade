<?php

namespace App\Http\Controllers;

use App\Models\TradingRule;
use Illuminate\Http\Request;

class TradingRuleController extends Controller
{
    public function index()
    {
        $rules = TradingRule::orderBy('order')->paginate(10); // atau jumlah per halaman yang diinginkan
        return view('rules.index', compact('rules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer'
        ]);

        TradingRule::create($request->all());

        return redirect()->route('trading-rules.index')
            ->with('success', 'Rule created successfully.');
    }

    public function updateOrder(Request $request, $id)
    {
        $request->validate([
            'direction' => 'required|in:up,down'
        ]);

        $rule = TradingRule::findOrFail($id);
        $neighbor = TradingRule::where(
            'order',
            $request->direction === 'up' ? '<' : '>',
            $rule->order
        )->orderBy('order', $request->direction === 'up' ? 'desc' : 'asc')->first();

        if ($neighbor) {
            // Swap orders
            $temp = $rule->order;
            $rule->order = $neighbor->order;
            $neighbor->order = $temp;

            $rule->save();
            $neighbor->save();
        }

        return response()->json(['success' => true]);
    }

    public function destroy(TradingRule $tradingRule)
    {
        // Detach from all trades first
        $tradingRule->trades()->detach();

        // Then delete the rule
        $tradingRule->delete();

        return redirect()->route('trading-rules.index')
            ->with('success', 'Rule deleted successfully.');
    }
}
