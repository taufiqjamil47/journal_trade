<?php

namespace App\Http\Controllers;

use App\Models\DashNote;
use Laravel\Prompts\Note;
use Illuminate\Http\Request;

class DashNoteController extends Controller
{
    public function index()
    {
        $notes = DashNote::latest()->get();
        return view('notes.index', compact('notes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'part_1_q1' => 'nullable|string',
            'part_1_q2' => 'nullable|string',
            'part_1_q3' => 'nullable|integer|min:0|max:10',
            'part_2_q4' => 'nullable|string',
            'part_2_q5' => 'nullable|string',
            'part_2_q5_text' => 'nullable|string',
            'part_3_q6' => 'nullable|boolean',
            'part_3_q7' => 'nullable|boolean',
            'part_3_q8' => 'nullable|boolean',
            'part_3_q9' => 'nullable|boolean',
            'part_4_q10' => 'nullable|string',
            'part_4_q11' => 'nullable|string',
            'part_5_text' => 'nullable|string',
            'part_6_q12' => 'nullable|boolean',
            'part_7_q13' => 'nullable|boolean',
            'part_7_q13_text' => 'nullable|string',
        ]);

        DashNote::create($validated);

        return redirect()->back()->with([
            'success' => 'Form berhasil disimpan!',
            'icon' => 'success'
        ]);
    }

    public function show(DashNote $note)
    {
        return view('notes.show', compact('note'));
    }

    public function edit(DashNote $note)
    {
        return view('notes.edit', compact('note'));
    }

    public function update(Request $request, DashNote $note)
    {
        $validated = $request->validate([
            'part_1_q1' => 'nullable|string',
            'part_1_q2' => 'nullable|string',
            'part_1_q3' => 'nullable|integer|min:0|max:10',
            'part_2_q4' => 'nullable|string',
            'part_2_q5' => 'nullable|string',
            'part_2_q5_text' => 'nullable|string',
            'part_3_q6' => 'nullable|boolean',
            'part_3_q7' => 'nullable|boolean',
            'part_3_q8' => 'nullable|boolean',
            'part_3_q9' => 'nullable|boolean',
            'part_4_q10' => 'nullable|string',
            'part_4_q11' => 'nullable|string',
            'part_5_text' => 'nullable|string',
            'part_6_q12' => 'nullable|boolean',
            'part_7_q13' => 'nullable|boolean',
            'part_7_q13_text' => 'nullable|string',
        ]);

        $note->update($validated);

        return redirect()->back()->with([
            'success' => 'Form berhasil diperbarui!',
            'icon' => 'success'
        ]);
    }

    public function destroy(DashNote $note)
    {
        $note->delete();

        return redirect()->back()->with([
            'success' => 'Catatan berhasil dihapus!',
            'icon' => 'success'
        ]);
    }
}
