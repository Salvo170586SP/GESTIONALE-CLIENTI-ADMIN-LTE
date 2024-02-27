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
                 <h6>Modifica evento "{{$appointment->title}}" del {{$appointment->start}}</h6>
                <a href="{{ route('admin.calendar.index') }}" class="d-flex align-items-center btn btn-secondary">
                    <span class="mr-2">Torna al calendario</span>
                    <i class="fa fa-solid fa-list"></i>
                </a>
        </div>
        <div class="col-12">
                @include('admin.partials.errors')
        </div>
        <div class="col-12 mt-2">
            <div class="card card-primary p-3">
                <form action="{{ route('admin.calendar.update', $appointment->id) }}" method="post">
                    @csrf
                    @method('put')

                    <div class="form-group">
                                  
                        <div class="mt-3 ">
                            <label for="title">Titolo</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') border border-danger @enderror" value="{{old('title', $appointment->title)}}" />
                        </div>
                        <div class="text-danger mt-1">
                            @error('title')
                            <span>{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="description">Descrizione</label>
                            <textarea rows="5" id="description" name="description"
                                class="form-control">{{old('description', $appointment->description)}}</textarea>
                        </div>
                        <div class="mt-3">
                            <label for="start">Inizio</label>
                            <input type="datetime-local" name="start"
                               id="start" class="form-control" value="{{old('start', $appointment->start)}}">
                        </div>
                        <div class="mt-3">
                            <label for="end">Fine</label>
                            <input type="datetime-local" name="end"  
                                id="end" class="form-control" value="{{old('end', $appointment->end)}}">
                        </div>

                        <div class="pt-5 text-end modal-footer">
                            <button type="submit" i class="btn btn-secondary">
                                aggiorna </button>
                          
                        </div>
                    </div>
                 </form>
            </div>
        </div>
    </div>

    @endsection