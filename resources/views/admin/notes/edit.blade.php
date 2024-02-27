@extends('layouts.admin')
@section('menuLinks')
<div class="row">
    <div class="col-12 my-2">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a> </li>
            <li class="breadcrumb-item"><a href="{{ route('admin.clients.index') }}">Clienti</a> </li>
            <li class="breadcrumb-item"><a href="{{ route('admin.notes.index', $client->id) }}">Appunti</a> </li>
            <li class="breadcrumb-item">Modifica</li>
        </ol>
    </div>
</div>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mb-2">
            <div class="d-flex align-items-center ">
                <a href="{{ route('admin.clients.index') }}" class="d-flex align-items-center btn btn-secondary">
                    <span class="mr-2">Torna alla lista dei clienti</span>
                    <i class="fa fa-solid fa-list"></i>
                </a>
            </div>
            <div class="d-flex align-items-center ">
                <a href="{{ route('admin.notes.index', $client->id) }}"
                    class="d-flex align-items-center btn btn-secondary">
                    <span class="mr-2">Torna gli appunti</span>
                    <i class="fa fa-solid fa-list"></i>
                </a>
            </div>
        </div>
        <div class="col-12 mt-2">
            <div class="card card-primary p-3">
                <form action="{{ route('admin.notes.update', [$client->id, $note->id]) }}" method="post">
                    @csrf
                    @method('put')

                    @include('admin.notes.form')
                    <button class="btn btn-primary">aggiorna</button>
                </form>
            </div>
        </div>
    </div>

    @endsection

    @section('additionalscripts')
    <script>
        ClassicEditor.create(document.querySelector('#editor'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote']
        })
        .catch(error => {
            console.error(error);
        });
    </script>
    @endsection