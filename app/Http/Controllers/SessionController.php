<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function index()
    {
        $sessions = Session::orderBy('id')->paginate(5);
        return view('sessions.index', compact('sessions'));
    }

    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50',
            'start_hour' => 'required|integer|min:0|max:23',
            'end_hour' => 'required|integer|min:0|max:23',
        ]);

        Session::create($data);
        return redirect()->route('sessions.index')->with('success', 'Session created.');
    }

    public function edit(Session $session)
    {
        return view('sessions.edit', compact('session'));
    }

    public function update(Request $request, Session $session)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50',
            'start_hour' => 'required|integer|min:0|max:23',
            'end_hour' => 'required|integer|min:0|max:23',
        ]);

        $session->update($data);
        return redirect()->route('sessions.index')->with('success', 'Session updated.');
    }

    public function destroy(Session $session)
    {
        $session->delete();
        return redirect()->route('sessions.index')->with('success', 'Session deleted.');
    }
}
