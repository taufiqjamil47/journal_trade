<?php

namespace App\Http\Controllers;

use App\Models\TradingRule;
use Illuminate\Http\Request;

class TradingRuleController extends Controller
{
    public function index()
    {
        $rules = TradingRule::orderBy('order')->paginate(20); // atau jumlah per halaman yang diinginkan
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

    public function update(Request $request, TradingRule $tradingRule)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean' // tambahkan ini
        ]);

        $tradingRule->update([
            'name' => $request->name,
            'description' => $request->description,
            'order' => $request->order,
            'is_active' => $request->is_active ?? true
        ]);

        return redirect()->route('trading-rules.index')
            ->with('success', 'Rule updated successfully.');
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

    public function reorder(Request $request)
    {
        $request->validate([
            'rules' => 'required|array',
            'rules.*.id' => 'required|exists:trading_rules,id',
            'rules.*.order' => 'required|integer'
        ]);

        foreach ($request->rules as $item) {
            TradingRule::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true, 'message' => 'Order updated successfully']);
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
