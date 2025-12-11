<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SessionController extends Controller
{
    public function index()
    {
        try {
            $sessions = Session::orderBy('id')->paginate(5);
            return view('sessions.index', compact('sessions'));
        } catch (\Exception $e) {
            Log::error('Error loading sessions: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat daftar session');
        }
    }

    public function create()
    {
        try {
            return view('sessions.create');
        } catch (\Exception $e) {
            Log::error('Error loading create session form: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat form pembuatan session');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:50|unique:sessions,name',
                'start_hour' => 'required|integer|min:0|max:23',
                'end_hour' => 'required|integer|min:0|max:23',
            ]);

            Session::create($validated);

            Log::info('Session created', ['name' => $validated['name']]);
            return redirect()->route('sessions.index')->with('success', 'Session berhasil dibuat.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation error when creating session', ['errors' => $e->errors()]);
            return back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error('Error creating session: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal membuat session: ' . $e->getMessage());
        }
    }

    public function edit(Session $session)
    {
        try {
            return view('sessions.edit', compact('session'));
        } catch (\Exception $e) {
            Log::error('Error loading edit session form: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat form edit session');
        }
    }

    public function update(Request $request, Session $session)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:50|unique:sessions,name,' . $session->id,
                'start_hour' => 'required|integer|min:0|max:23',
                'end_hour' => 'required|integer|min:0|max:23',
            ]);

            $session->update($validated);

            Log::info('Session updated', ['id' => $session->id, 'name' => $validated['name']]);
            return redirect()->route('sessions.index')->with('success', 'Session berhasil diperbarui.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation error when updating session', ['errors' => $e->errors()]);
            return back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error('Error updating session: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal memperbarui session: ' . $e->getMessage());
        }
    }

    public function destroy(Session $session)
    {
        try {
            $sessionId = $session->id;
            $sessionName = $session->name;

            $session->delete();

            Log::info('Session deleted', ['id' => $sessionId, 'name' => $sessionName]);
            return redirect()->route('sessions.index')->with('success', 'Session berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting session: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus session: ' . $e->getMessage());
        }
    }
}
