<?php

namespace App\Http\Controllers;

use App\Models\TradingRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class TradingRuleController extends Controller
{
    public function index()
    {
        try {
            $rules = TradingRule::orderBy('order')->paginate(20);
            return view('rules.index', compact('rules'));
        } catch (\Exception $e) {
            Log::error('Error loading trading rules: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat daftar rules');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:trading_rules,name',
                'description' => 'nullable|string',
                'order' => 'nullable|integer'
            ]);

            DB::transaction(function () use ($validated) {
                TradingRule::create($validated);
            });

            Log::info('Trading rule created', ['name' => $validated['name']]);
            return redirect()->route('trading-rules.index')
                ->with('success', 'Rule berhasil dibuat.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation error when creating rule', ['errors' => $e->errors()]);
            return back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error('Error creating trading rule: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal membuat rule: ' . $e->getMessage());
        }
    }

    public function update(Request $request, TradingRule $tradingRule)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:trading_rules,name,' . $tradingRule->id,
                'description' => 'nullable|string',
                'order' => 'nullable|integer',
                'is_active' => 'boolean'
            ]);

            DB::transaction(function () use ($tradingRule, $validated) {
                $tradingRule->update([
                    'name' => $validated['name'],
                    'description' => $validated['description'] ?? null,
                    'order' => $validated['order'] ?? $tradingRule->order,
                    'is_active' => $validated['is_active'] ?? true
                ]);
            });

            Log::info('Trading rule updated', ['id' => $tradingRule->id, 'name' => $validated['name']]);
            return redirect()->route('trading-rules.index')
                ->with('success', 'Rule berhasil diperbarui.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation error when updating rule', ['errors' => $e->errors()]);
            return back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error('Error updating trading rule: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal memperbarui rule: ' . $e->getMessage());
        }
    }

    public function updateOrder(Request $request, $id)
    {
        try {
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
                DB::transaction(function () use ($rule, $neighbor, $id, $request) {
                    // Swap orders
                    $temp = $rule->order;
                    $rule->order = $neighbor->order;
                    $neighbor->order = $temp;

                    $rule->save();
                    $neighbor->save();

                    Log::info('Trading rule order updated', ['rule_id' => $id, 'direction' => $request->direction]);
                });
            }

            return response()->json(['success' => true]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning("Trading rule not found: ID {$id}");
            return response()->json(['success' => false, 'message' => 'Rule tidak ditemukan'], 404);
        } catch (\Exception $e) {
            Log::error('Error updating rule order: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal mengupdate urutan'], 500);
        }
    }

    public function reorder(Request $request)
    {
        try {
            $request->validate([
                'rules' => 'required|array',
                'rules.*.id' => 'required|exists:trading_rules,id',
                'rules.*.order' => 'required|integer'
            ]);

            DB::transaction(function () use ($request) {
                foreach ($request->rules as $item) {
                    TradingRule::where('id', $item['id'])->update(['order' => $item['order']]);
                }
            });

            Log::info('Trading rules reordered', ['count' => count($request->rules)]);
            return response()->json(['success' => true, 'message' => 'Urutan berhasil diperbarui']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation error when reordering rules');
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error reordering rules: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal mengupdate urutan'], 500);
        }
    }

    public function destroy(TradingRule $tradingRule)
    {
        try {
            $ruleId = $tradingRule->id;
            $ruleName = $tradingRule->name;

            DB::transaction(function () use ($tradingRule) {
                // Detach from all trades first
                $tradingRule->trades()->detach();

                // Then delete the rule
                $tradingRule->delete();
            });

            Log::info('Trading rule deleted', ['id' => $ruleId, 'name' => $ruleName]);
            return redirect()->route('trading-rules.index')
                ->with('success', 'Rule berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting trading rule: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus rule: ' . $e->getMessage());
        }
    }
}
