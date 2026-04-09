<?php

namespace App\Http\Controllers;

use App\Models\Symbol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SymbolController extends Controller
{
    /**
     * Menampilkan daftar sumber daya.
     */
    public function index()
    {
        try {
            $symbols = Symbol::orderBy('id')->get();
            return view('symbols.index', compact('symbols'));
        } catch (\Exception $e) {
            Log::error('Error loading symbols: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat daftar simbol');
        }
    }

    /**
     * Menampilkan form untuk membuat sumber daya baru.
     */
    public function create()
    {
        try {
            return view('symbols.create');
        } catch (\Exception $e) {
            Log::error('Error loading create symbol form: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat form pembuatan simbol');
        }
    }

    /**
     * Simpan sumber daya yang baru dibuat di penyimpanan.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100|unique:symbols,name',
                'pip_value' => 'required|numeric',
                'pip_worth' => 'nullable|numeric',
                'pip_position' => 'nullable|string',
                'active' => 'required|in:0,1', // ubah dari nullable ke required
            ]);

            Symbol::create($validated);

            Log::info('Symbol created', ['name' => $validated['name']]);
            return redirect()->route('symbols.index')->with('success', 'Symbol berhasil dibuat.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation error when creating symbol', ['errors' => $e->errors()]);
            return back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error('Error creating symbol: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal membuat simbol: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan formulir untuk mengedit sumber daya yang ditentukan.
     */
    public function edit($id)
    {
        try {
            $symbol = Symbol::findOrFail($id);
            return view('symbols.edit', compact('symbol'));
        } catch (\Exception $e) {
            Log::error('Error loading edit symbol form: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat form edit simbol');
        }
    }

    /**
     * Perbarui sumber daya yang ditentukan dalam penyimpanan.
     */
    public function update(Request $request, $id)
    {
        try {
            $symbol = Symbol::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:100|unique:symbols,name,' . $symbol->id,
                'pip_value' => 'required|numeric',
                'pip_worth' => 'nullable|numeric',
                'pip_position' => 'nullable|string',
                'active' => 'required|in:0,1', // ubah dari nullable ke required
            ]);

            $symbol->update($validated);

            Log::info('Symbol updated', ['name' => $validated['name']]);
            return redirect()->route('symbols.index')->with('success', 'Symbol berhasil diperbarui.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation error when updating symbol', ['errors' => $e->errors()]);
            return back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error('Error updating symbol: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal memperbarui simbol: ' . $e->getMessage());
        }
    }

    /**
     * Hapus sumber daya yang ditentukan dari penyimpanan.
     */
    public function destroy($id)
    {
        $symbol = Symbol::findOrFail($id);
        try {
            $symbol->delete();
            return redirect()->route('symbols.index')->with('success', 'Symbol deleted');
        } catch (\Exception $e) {
            Log::error('Error deleting symbol: ' . $e->getMessage());
            return redirect()->route('symbols.index')->with('error', 'Failed to delete symbol');
        }
    }
}
