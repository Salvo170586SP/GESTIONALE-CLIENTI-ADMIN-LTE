@extends('layouts.admin')
@section('menuLinks')
<div class="row">
    <div class="col-12 my-2">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a> </li>
            <li class="breadcrumb-item"><a href="{{ route('admin.clients.index') }}">Clienti</a> </li>
            <li class="breadcrumb-item">Appunti</li>
        </ol>
    </div>
</div> 
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-between mb-3">
                <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#creaNote">
                    <i class="fa-solid fa-plus"></i>
                    <span>Aggiungi</span>
                </button>

                <!-- Modal -->
                <div class="modal fade" id="creaNote" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="d-flex align-items-center">
                                    <i class="fa-solid fa-plus fa-2x mr-3"></i>
                                    <h5 class="modal-title" id="exampleModalLabel">Crea appunti</h5>
                                </div>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body m-0 p-0">
                                <form action="{{ route('admin.notes.store', $client->id) }}" method="POST">
                                    @csrf
                                    <div class="p-3">
                                        @include('admin.notes.form')
                                    </div>
                                    <div class="modal-footer">
                                            <button class="btn btn-primary">
                                               crea
                                           </button>
                                            <button type="button" class="btn btn-light" data-dismiss="modal">chiudi</button>
                                        </div>
                                 </form>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary d-flex align-items-center">
                    <span>Torna alla lista</span>
                    <i class="fa-solid fa-list ml-2"></i>
                </a>
            </div>
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <h3 class="profile-username text-center mb-4">{{Str::upper($client->name_client)}} {{Str::upper($client->surname_client)}}</h3>
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-bold">Data di nascita</span> <span>{{ $client->date_of_birth ?? '-' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-bold">Città di nascita</span> <span>{{ $client->city_of_birth ?? '-' }} </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-bold">Indirizzo</span> <span>{{ $client->address ?? '-' }} , {{ $client->cap ?? '-' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="activity">
                                <div class="post">
                                    <div class="mt-1 mb-2">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="d-flex justify-content-between">
                                                    <h3>Appunti</h3>
                                                    @if(count($client->notes) > 1)
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-danger text-sm d-flex align-items-center" data-toggle="modal" data-target="#deleteAllFile{{$client->id}}">
                                                        <span class="mr-2">elimina tutti gli appunti</span>
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="deleteAllFile{{$client->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                <div class="modal-body p-0 m-0">
                                                                    <form action="{{ route('admin.notes.deleteAllNote', $client->id) }}" method="post">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <p class="p-3">Vuoi eliminare tutti i tuoi appunti?</p>
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
                                            </div>
                                        </div>

                                        @forelse($client->notes as $note)
                                        <div class="row">
                                            <div class="col-12 d-flex flex-column my-2">

                                                <div class="p-3 border border-slate rounded">
                                                    <div class="d-flex justify-content-between">
                                                        <h2>
                                                            {!! $note->title_note !!}
                                                        </h2>
                                                        <div class="d-flex justify-content-between my-2">
                                                            <button type="button" class="btn btn-danger text-sm d-flex align-items-center mr-2" data-toggle="modal" data-target="#deleteNote{{$note->id}}">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                            <!-- Modal -->
                                                            <div class="modal fade" id="deleteNote{{$note->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                            <form action="{{ route('admin.notes.destroy', [$client->id, $note->id]) }}" method="POST">
                                                                                @csrf
                                                                                @method('delete')
                                                                                <p class="p-3">Sei sicuro di eliminare {{ $note->title_note }}</p>
                                                                                <div class="modal-footer">
                                                                                    <button class="btn btn-danger">
                                                                                        elimina nota
                                                                                    </button>
                                                                                    <button type="button" class="btn btn-light" data-dismiss="modal">chiudi</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Button trigger modal -->
                                                            <a href="{{ route('admin.notes.edit', [$client->id, $note->id]) }}" class="btn btn-secondary">
                                                                <i class="fa fa-solid fa-edit"></i>
                                                            </a>
                                                        </div>

                                                    </div>
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <small>
                                                            creata il: {{ $note->created_at  }}
                                                        </small>
                                                        <small>
                                                            modificata il: {{ $note->updated_at  }}
                                                        </small>
                                                    </div>

                                                    <p>{!! $note->text_note !!}</p>
                                                    <div class="d-flex align-items-center">
                                                        <small class="mr-1">
                                                            Appuntamento per:
                                                        </small>
                                                        @if($note->date)
                                                        <div class="flex ml-2 text-sm">
                                                            {{ $note->getDayWeekDateNote() }}
                                                            {{ $note->getDayDateNote() }}
                                                            {{ $note->getMonthDateNote() }}
                                                            {{ $note->getYearDateNote() }}
                                                        </div>
                                                        @else
                                                        -
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                        <div class="text-center">
                                            <span>NON CI SONO APPUNTI</span>
                                        </div>
                                        @endforelse
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