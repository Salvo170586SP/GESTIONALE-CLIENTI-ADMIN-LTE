@extends('layouts.admin')
@section('menuLinks')
<div class="row">
    <div class="col-12 my-2">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a> </li>
            <li class="breadcrumb-item">Note personali</li>
        </ol>
    </div>
</div>
@endsection
@section('content')

<section id="note">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="activity">
                                <div class="post">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="d-flex justify-content-between  align-items-center">
                                                <h3 class="mt h3">Note <span class="text-md bg-secondary rounded px-2 py-1">{{ count($todos)}} @if(count($todos) > 1) note @else nota @endif</span></h3>
                                                <button type="button" class="btn btn-primary my-3" data-toggle="modal" data-target="#creaNota">
                                                    <i class="fa-solid fa-plus  "></i>
                                                    Crea nota
                                                </button>
                                                <div class="modal fade" id="creaNota" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="fa-solid fa-plus fa-2x mr-3"></i>
                                                                    <h5 class="modal-title" id="exampleModalLabel">Crea nota</h5>
                                                                </div>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body m-0 p-0">
                                                                <form action="{{route('admin.todos.store')}}" method="post">
                                                                    @csrf

                                                                    <div class="p-3">
                                                                        <label for="title">Titolo</label>
                                                                        <input type="text" class="form-control" name="title" id="title">
                                                                        <span id="titleError" class="text-danger"></span>
                                                                    </div>
                                                                    <div class="p-3">
                                                                        <label for="description">descrizione</label>
                                                                        <textarea type="text" class="form-control" name="description" id="description"></textarea>
                                                                        <span id="titleError" class="text-danger"></span>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit" id="saveBtn" class="btn btn-secondary">salva</button>
                                                                        <button type="button" class="btn btn-light" data-dismiss="modal">chiudi</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            @if(count($todos) > 1)
                                            <button type="button" class="btn btn-danger d-flex align-items-center" data-toggle="modal" data-target="#deleteAllFile">
                                                <span class="mr-2">elimina tutte le note</span>
                                                <i class="fa-solid fa-trash"></i>
                                            </button>

                                            <div class="modal fade" id="deleteAllFile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fa-solid fa-circle-exclamation fa-2x mr-3"></i>
                                                                <h5 class="modal-title" id="exampleModalLabel">Attenzione</h5>
                                                            </div>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body  m-0 p-0">
                                                            <form action="{{route('admin.todos.delete_AllNotes')}}" method="post">
                                                                @csrf
                                                                @method('delete')
                                                                <p class="p-3">Sei sicuro di voler eliminare tutte le note?</p>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-danger">
                                                                        elimina tutti
                                                                    </button>
                                                                    <button type="button" class="btn btn-light" data-dismiss="modal">chiudi</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="col-sm-12">
                                            <div style="height: 35px; margin: 8px 0">
                                                @include('admin.partials.messages')
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            @if(count($todos) > 0)
                                            @foreach($todos as $todo)
                                            <div class="card p-2">
                                                <div class="d-flex justify-content-between">

                                                    <div>
                                                        <small>creazione/ultima modifica: {{$todo->updated_at}}</small>
                                                       
                                                    </div>
                                                    <div class="d-flex">
                                                        <form action="{{ route('admin.todos.selectTodo', $todo->id) }}" method="get" class="mr-2">
                                                            @csrf
                                                            <button type="submit" class="btn btn-secondary">@if($todo->is_active == true) completato @else non completato @endif</button>
                                                        </form>
                                                        <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#editTodo{{$todo->id}}">
                                                            <i class="fa-solid fa-edit"></i>
                                                        </button>
                                                        <div class="modal fade" id="editTodo{{$todo->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <div class="d-flex align-items-center">
                                                                            <i class="fa-solid fa-circle-exclamation fa-2x mr-3"></i>
                                                                            <h5 class="modal-title" id="exampleModalLabel">Modifica nota</h5>
                                                                        </div>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body m-0 p-0">
                                                                        <form action="{{route('admin.todos.update', $todo->id)}}" method="post">
                                                                            @csrf
                                                                            @method('put')
                                                                            <div class="p-3">
                                                                                <label for="title">Titolo</label>
                                                                                <input type="text" class="form-control" name="title" id="title" value="{{old('title', $todo->title)}}">
                                                                                <span id="titleError" class="text-danger"></span>
                                                                            </div>
                                                                            <div class="p-3">
                                                                                <label for="description">descrizione</label>
                                                                                <textarea type="text" class="form-control" name="description" id="description">{{old('description', $todo->description)}}</textarea>
                                                                                <span id="titleError" class="text-danger"></span>
                                                                            </div>

                                                                            <div class="modal-footer">
                                                                                <button class="btn btn-primary text-sm">
                                                                                    modifica
                                                                                </button>
                                                                                <button type="button" class="btn btn-light" data-dismiss="modal">chiudi</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-danger mr-2" data-toggle="modal" data-target="#deleteFile{{$todo->id}}">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                        <div class="modal fade" id="deleteFile{{$todo->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <div class="d-flex align-items-center">
                                                                            <i class="fa-solid fa-circle-exclamation fa-2x mr-3"></i>
                                                                            <h5 class="modal-title" id="exampleModalLabel">Attenzione</h5>
                                                                        </div>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body m-0 p-0">
                                                                        <form action="{{route('admin.todos.destroy', $todo->id)}}" method="post">
                                                                            @csrf
                                                                            @method('delete')
                                                                            <p class="p-3">Sei sicuro di voler eliminare {{ $todo->title }}?</p>
                                                                            <div class="modal-footer">
                                                                                <button class="btn btn-danger text-sm">
                                                                                    elimina
                                                                                </button>
                                                                                <button type="button" class="btn btn-light" data-dismiss="modal">chiudi</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <h2>{{ $todo->title }}</h2>
                                                    <p style="@if($todo->is_active == true) text-decoration-line: line-through @endif">{{ $todo->description }}</p>
 
                                                   
                                                </div>
                                            </div>
                                            @endforeach

                                            @else
                                            <div class="text-center">
                                                <span>NON CI SONO NOTE</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection
