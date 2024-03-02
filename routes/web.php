<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
use App\Models\Appointment;
use App\Models\Client;
use App\Models\Todo;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/dashboard', function () {
    $clients = Client::all();
    $todos = Todo::all();
    $appointments = Appointment::all();
    return view('dashboard', compact('clients', 'todos', 'appointments'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->name('admin.')->group(function () {
    /* CLIENT */
    Route::resource('/admin/clients', ClientController::class);
      
    /* CLIENT FILE */
    Route::get('admin/files/{client}', [FileController::class, 'index'])->name('files.index');
    Route::post('admin/files', [FileController::class, 'store'])->name('files.store');
    Route::delete('/admin/files/delete_file/{client}-{file}', [FileController::class, 'destroy'])->name('files.destroy');
    Route::delete('/admin/files/delete_Allfile/{client}', [FileController::class, 'delete_Allfile'])->name('files.delete_Allfile');
    Route::get('/admin/files/downloadFile/{client}/{file}', [FileController::class, 'downloadFile'])->name('files.downloadFile');

    /* CLIENT NOTES */
    Route::get('admin/notes/{client}', [NoteController::class, 'index'])->name('notes.index');
    Route::get('admin/notes/edit/{client}/{note}', [NoteController::class, 'edit'])->name('notes.edit');
    Route::post('admin/notes/store/{client}', [NoteController::class, 'store'])->name('notes.store');
    Route::put('admin/notes/update/{client}/{note}', [NoteController::class, 'update'])->name('notes.update');
    Route::delete('admin/notes/delete/{client}/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');
    Route::delete('admin/notes/deleteAllNote/{client}', [NoteController::class, 'deleteAllNote'])->name('notes.deleteAllNote');

    /* TODOS */
    Route::get('/admin/todos', [TodoController::class, 'index'])->name('todos.index');
    Route::post('/admin/todos/store', [TodoController::class, 'store'])->name('todos.store');
    Route::put('admin/todos/update/{todo}', [TodoController::class, 'update'])->name('todos.update');
    Route::delete('admin/todos/delete/{todo}', [TodoController::class, 'destroy'])->name('todos.destroy');
    Route::delete('admin/todos/deleteAllNote', [TodoController::class, 'delete_AllNotes'])->name('todos.delete_AllNotes');
    Route::get('admin/todos/selectTodo/{todo}', [TodoController::class, 'selectTodo'])->name('todos.selectTodo');

    /* CALENDAR */
    Route::get('/admin/calendar', [AppointmentController::class, 'index'])->name('calendar.index');
    Route::get('/admin/calendar/getAppointments', [AppointmentController::class, 'getAppointments'])->name('calendar.getAppointments');
    Route::get('/admin/calendar/{appointment}/detail', [AppointmentController::class, 'show'])->name('calendar.show');
    Route::delete('/admin/calendar/{appointment}', [AppointmentController::class, 'destroy'])->name('calendar.destroy');
    Route::put('/admin/calendar/{appointment}/dateUpdate', [AppointmentController::class, 'dateUpdate'])->name('calendar.dateUpdate');
    Route::post('/admin/calendar/store', [AppointmentController::class, 'store'])->name('calendar.store');
    Route::get('/admin/calendar/{appointment}/edit', [AppointmentController::class, 'edit'])->name('calendar.edit');
    Route::put('/admin/calendar/{appointment}/update', [AppointmentController::class, 'update'])->name('calendar.update');
});

require __DIR__ . '/auth.php';
