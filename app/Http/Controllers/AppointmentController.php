<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::all();
        $user = Auth::user();
        return view('admin.calendar.index', compact('clients', 'user'));
    }

    public function getAppointments()
    {
        $appointments = Appointment::where('user_id', Auth::id())->get();

        return response()->json($appointments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max: 15'
        ],[
            'required' => 'Il titolo è obbligatorio',
            'max' => 'puoi inserire massimo 15 caratteri'
        ]);

        $appointment = new Appointment();
        $appointment->user_id = Auth::id();
        $appointment->title = $request->title;
        $appointment->description = $request->description;
        $appointment->start = $request->start;
        $appointment->end = $request->end;
        $appointment->save();

        return back()->with('success','evento creato con successo');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        $clients = Client::all();

        return view('admin.calendar.show', compact('clients', 'appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        $clients = Client::all();

        return view('admin.calendar.edit', compact('clients', 'appointment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'title' => 'required|max: 15'
        ],[
            'required' => 'Il titolo è obbligatorio',
            'max' => 'puoi inserire massimo 15 caratteri'
        ]);

        if ($appointment->user_id == Auth::id()) {

            $appointment->update([
                'title' => $request->title,
                'description' => $request->description,
                'start' => $request->start,
                'end' => $request->end
            ]);
        }

        return redirect()->route('admin.calendar.index')->with('success','evento modificato con successo');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        if ($appointment->user_id == Auth::id()) {

            $appointment->delete();

        }
        return response()->json(['message' => 'evento eliminato con successo']);
     }

    public function dateUpdate(Request $request,  Appointment $appointment)
    {
        if($appointment->user_id == Auth::id()) {
            $appointment->update([
                'start' => Carbon::parse($request->input('start'))->setTimeZone('Europe/Rome'),
                'end' => Carbon::parse($request->input('end'))->setTimeZone('Europe/Rome')
            ]);
        }

        return response()->json(['message' => 'data aggiornata correttamente']);
    }
}
