<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Todo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::all();
        $todos = Todo::all();
        return view('admin.todos.index', compact('todos', 'clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {

            $todo = new Todo();
            $todo->user_id = Auth::id();
            $todo->title = $request->title;
            $todo->description = $request->description;
            $todo->save();

            return back()->with('success', 'Nota inserita con successo');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo)
    {
        try {

            $todo->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            return back()->with('success', 'Nota modificata con successo');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        try {

            if ($todo) {
                $todo->delete();
            }

            return back()->with('success', 'Nota eliminata con successo');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function delete_AllNotes()
    {
        try {

            $todos = Todo::all();
            foreach ($todos as $todo) {
                $todo->delete();
            }

            return back()->with('success', 'Note eliminate con successo');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function selectTodo(Todo $todo)
    {
 
        if ($todo->is_active == false) {
            $active = true;
        } else {
            $active = false;
        }

        $todo->is_active = $active;
        $todo->save();

        return redirect()->route('admin.todos.index');
    }
}
