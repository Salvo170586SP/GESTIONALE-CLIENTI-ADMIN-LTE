<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\File;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function index(Client $client)
    {
        $clients = Client::all();
        return view('admin.files.index', compact('client', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_file' => 'required'
        ], [
            'name_file.required' => 'Nome del file obbligatorio'
        ]);

        $file = new File();
        $file->client_id = $request->client_id;
        $file->name_file = $request->name_file;
        if (array_key_exists('url_file', $request->all())) {
            $url = Storage::put('/files_client', $request['url_file']);
            $file->url_file = $url;
        }
        $file->save();

        return back()->with('success', 'Il file è stato correttamente allegato al cliente');
    }


    public function destroy(Client $client, File $file)
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
