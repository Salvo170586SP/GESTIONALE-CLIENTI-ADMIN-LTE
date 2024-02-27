<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\File;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $search = $request->input('search');

        $clients = Client::where('user_id', Auth::id())->where(function ($query) use ($search) {
            $query->where('surname_client', 'like', "%$search%")
                ->orWhere("name_client", 'like', "%$search%");
        })->orderBy('id', 'ASC')->paginate(10);

        return view('admin.clients.index', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_client' => 'required|min:3',
            'surname_client' => 'required|min:3'
        ], [
            'name_client.required' => 'Nome del cliente obbligatorio',
            'surname_client.required' => 'Cognome del cliente obbligatorio'
        ]);

        try {
            $client = new Client();
            $client->user_id = Auth::id();
            $client->name_client = $request->name_client;
            $client->surname_client = $request->surname_client;
            $client->date_of_birth = $request->date_of_birth;
            $client->city_of_birth = $request->city_of_birth;
            $client->address = $request->address;
            $client->cap = $request->cap;
            $client->save();

            return back()->with('success', 'Cliente inserito con successo');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        $clients = Client::all();
        return view('admin.clients.show', compact('client', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name_client' => 'required',
            'surname_client' => 'required'
        ], [
            'name_client.required' => 'Nome del cliente obbligatorio',
            'surname_client.required' => 'Cognome del cliente obbligatorio'
        ]);

        try {
            if ($client->user_id === Auth::id()) {
                //UPDATE DELL'IMMAGINE MA SE NON CARICO UN ALTRA IMMAGINE ELIMINA L'IMMAGINE ESISTENTE E METTE IL PLACEHOLDER
                if ($request->hasfile('file_url')) {
                    if ($client->file_url == true) {
                        Storage::delete($client->file_url);
                    }

                    $url = Storage::put('/files_client', $request->file('file_url'));
                    $client->file_url = $url;
                }

                $client->update([
                    'name_client' => $request->name_client,
                    'surname_client' => $request->surname_client,
                    'date_of_birth' => $request->date_of_birth,
                    'city_of_birth' => $request->city_of_birth,
                    'address' => $request->address,
                    'cap' => $request->cap,
                ]);

            }
            return back()->with('success', 'Cliente aggiornato con successo');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {

        try {
            if ($client) {

                foreach ($client->files as $file) {

                    if ($file->url_file) {
                        Storage::delete($file->url_file);
                        $file->url_file = null;
                        $file->save();
                    }

                    $file->delete();
                }

                $client->delete();
            }

            return back()->with('success', 'Cliente eliminato con successo');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function delete_Allfile(Client $client)
    {
        try {
            foreach ($client->files as $file) {

                if ($file->url_file) {
                    Storage::delete($file->url_file);
                    $file->url_file = null;
                    $file->save();
                }

                $file->delete();
            }

            return back()->with('success', 'File eliminati con successo');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function delete_file(Client $client, File $file)
    {

        // mi assicuro che il file appartenga al cliente
        if ($client->id !== $file->client_id) {
            abort(403, 'Azione non autorizzata');
        }

        if ($file->url_file) {
            Storage::delete($file->url_file);
            $file->url_file = null;
            $file->save();
        }
        $file->delete();

        return back()->with('success', 'File eliminato con successo');
    }

    public function downloadFile(Client $client, File $file)
    {
        try {
            if ($client->id == $file->client_id && $file->id) {
                $filePath = public_path('storage/' . $file->url_file);
            }
            return response()->download($filePath, '');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
