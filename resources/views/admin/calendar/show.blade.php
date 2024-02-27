@extends('layouts.admin')
@section('menuLinks')
<div class="row">
    <div class="col-12 my-2">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a> </li>
            <li class="breadcrumb-item"><a href="{{ route('admin.calendar.index') }}">Calendario</a></li>
            <li class="breadcrumb-item">Modifica Evento</li>
        </ol>
    </div>
</div>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 d-flex align-items-center justify-content-between mb-2">
            <a href="{{ route('admin.calendar.index') }}" class="d-flex align-items-center btn btn-secondary">
                <span class="mr-2">Torna al calendario</span>
                <i class="fa fa-solid fa-list"></i>
            </a>
        </div>
        <div class="col-12 mt-2">
            <div class="card card-primary p-3">
                <div>
                    <h5>Titolo Evento: </h5>
                    <h4>{{$appointment->title}}</h4>
                </div>
                <div class="mt-3">
                    <h5>Descrizione: </h5>
                    <h4>{{ $appointment->description }}</h4>
                </div>

                <div class="mt-3 d-flex align-items-center">
                    <div class="mr-3 d-flex align-items-center">
                        <h6 class="m-0 pr-2">Inizio: </h6>
                        <span> {{ $appointment->start }}</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <h6 class="m-0 pr-2">Fine: </h6>
                        <span> {{ $appointment->end }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection