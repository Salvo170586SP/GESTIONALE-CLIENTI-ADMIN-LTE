<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Note;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Client $client)
    {
        $clients = Client::all();
        return view('admin.notes.index', compact('client', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Client $client)
    {
        try {

            $note = new Note();
            $note->title_note = $request->title_note;
            $note->text_note = $request->text_note;
            $note->date = $request->date;
            $note->client_id = $client->id;
            $note->save();

            return back()->with('success', 'Nota cliente creata con successo');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client, Note $note)
    {
        $clients = Client::all();
        return view('admin.notes.edit', compact('note', 'client', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client, Note $note)
    {
        try {
            if ($client->id == $note->client_id) {
                $note->update([
                    'title_note' => $request->title_note,
                    'text_note' => $request->text_note,
                    'date' => $request->date,
                    'client_id' => $client->id,
                ]);
            }
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.notes.index', compact('note', 'client'))->with('success', 'Nota cliente modificata con successo');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client, Note $note)
    {
        if ($client) {
            $note->delete();
        }

        return back()->with('success', 'Nota cliente eliminata con successo');
    }

    public function deleteAllNote(Client $client)
    {
        if ($client) {
            foreach ($client->notes as $note) {
                $note->delete();
            }
        }

        return back()->with('success', 'Note cliente eliminate con successo');
    }
}
