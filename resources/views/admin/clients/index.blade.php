@extends('layouts.admin')
@section('menuLinks')
<div class="row">
    <div class="col-12 my-2">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a> </li>
            <li class="breadcrumb-item">Clienti</li>
        </ol>
    </div>
</div>
@endsection
@section('content')
<section class="px-4">
    <div class="row">
        <div class="col-6">
            <div class="d-flex align-items-center">
                <h2 class="text-muted mr-3">Clienti</h2>
                <span class="px-2 py-1 text-primary rounded bg-info">{{ count($clients) }} clienti</span>
            </div>
        </div>

        <div class="col-6 d-flex justify-content-end">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary d-flex align-items-center" data-toggle="modal"
                data-target="#exampleModal">
                <span class="mr-2">Aggiungi cliente</span>
                <i class="fa-solid fa-plus fa-2x"></i>
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-plus fa-2x mr-3"></i>
                                <h5 class="modal-title" id="exampleModalLabel">Aggiungi cliente</h5>
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body m-0 p-0">
                            @include('admin.partials.errors')
                            <form action="{{ route('admin.clients.store') }}" method="POST" id="form" enctype="multipart/form-data">
                                @csrf

                                <div class="p-3">
                                    @include('admin.clients.form')
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-primary">
                                        aggiungi
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



    <div class="row">
        <div class="col-12">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-12">
                        <div style="height: 15px; margin: 8px 0">
                            @include('admin.partials.messages')
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 d-flex justify-content-between align-items-center mt-3 mb-2">
                        <div class="d-flex align-items-center">
                            <form action="{{ route('admin.clients.index') }}" method="get">
                                @csrf
                                <div class="d-flex align-items-center">
                                    <input type="text" class="form-control mr-2" name="search"
                                        placeholder="Cerca cliente per cognome">
                                    <button type="submit"
                                        class="btn btn-secondary text-white  px-2 py-1 mr-2">cerca</button>
                                </div>
                            </form>
                            <a href="{{ route('admin.clients.index') }}"
                                class="btn btn-danger text-white  px-2 py-1">Reset</a>
                        </div>

                        <div class="pt-3">
                            @if($clients instanceof \Illuminate\Pagination\LengthAwarePaginator && $clients->hasPages())
                            {{ $clients->links('pagination::bootstrap-4') }}
                            @else
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline"
                            aria-describedby="example1_info">
                            <thead>
                                <tr>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">
                                        Nome
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">
                                        Cognome
                                    </th>

                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">
                                        Data di nascita
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">
                                        Città di nascita</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">
                                        Indirizzo</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">
                                        Cap</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">
                                    </th>                             
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($clients as $client)
                                <tr>
                                    <td>
                                        {{Str::upper($client->name_client)}}
                                    </td>
                                    <td>
                                        {{Str::upper($client->surname_client)}}
                                    </td>
                                    <td>
                                        {{ $client->date_of_birth ?? '-' }}
                                    </td>
                                    <td>
                                        {{ $client->city_of_birth ?? '-' }}
                                    </td>
                                    <td>
                                        {{ $client->address ?? '-' }}
                                    </td>
                                    <td>
                                        {{ $client->cap ?? '-' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.files.index', $client->id) }}"
                                            class="btn btn-info text-sm flex justify-content-center align-items-center">
                                            <span class="mr-2">allega file</span>
                                            <i class="fa-solid fa-plus"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a class="d-flex align-items-center justify-content-between btn btn-secondary"
                                            href="{{ route('admin.notes.index', $client->id) }}">
                                            <span class="text-sm">crea appunti</span>
                                            <i class="fa-solid fa-list ml-2"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <a href="{{ route('admin.clients.show', $client->id) }}"
                                                class="btn btn-info text-sm flex justify-content-center align-items-center">
                                                <span class="mr-2">dettagli</span>
                                                <i class="fa-solid fa-eye"></i>
                                            </a>

                                            <button type="button" class="btn btn-primary d-flex align-items-center mx-2"
                                                data-toggle="modal" data-target="#editClient{{$client->id}}">
                                                <span class="mr-2 text-sm">modifica</span>
                                                <i class="fa-solid fa-edit"></i>
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="editClient{{$client->id}}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fa-solid fa-edit fa-2x mr-3"></i>
                                                                <h5 class="modal-title" id="exampleModalLabel">Modifica
                                                                    di {{ $client->name_client }} {{
                                                                    $client->surname_client }}</h5>
                                                            </div>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body m-0 p-0">
                                                            <form
                                                                action="{{ route('admin.clients.update', $client->id) }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('put')
                                                                <div class="p-3">
                                                                    @include('admin.clients.form')
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-primary">
                                                                        aggiorna
                                                                    </button>
                                                                    <button type="button" class="btn btn-light"
                                                                        data-dismiss="modal">chiudi</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="button" class="btn btn-danger d-flex align-items-center"
                                                data-toggle="modal" data-target="#deleteClient{{$client->id}}">
                                                <span class="mr-2 text-sm">elimina</span>
                                                <i class="fa-solid fa-trash"></i>
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="deleteClient{{$client->id}}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <div class="d-flex align-items-center">
                                                                <i
                                                                    class="fa-solid fa-circle-exclamation fa-2x mr-3"></i>
                                                                <h5 class="modal-title" id="exampleModalLabel">
                                                                    Attenzione</h5>
                                                            </div>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body m-0 p-0">
                                                            <form
                                                                action="{{ route('admin.clients.destroy', $client->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('delete')
                                                                <p class="p-3">Sei sicuro di eliminare {{
                                                                    $client->name_client }} {{ $client->surname_client
                                                                    }}?</p>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-danger">
                                                                        elimina
                                                                    </button>
                                                                    <button type="button" class="btn btn-light"
                                                                        data-dismiss="modal">chiudi</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <th>
                                        NON CI SONO CLIENTI
                                    </th>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


{{-- MOASTRA ERROR BAG DA JSON --}}
@section('additionalscripts')
<script>
    $(document).ready(function() {
                //mostra error bag form "aggiungi cliente" 
                $('#exampleModal').on('hidden.bs.modal', function() {
                    // Ricarica la pagina se la modale è stata chiusa senza essere confermata
                    location.reload();
                });
                  @if($errors->has('name_client') || $errors->has('surname_client')) 
                      $('#exampleModal').modal('show');
                  @endif
                
              

                    //error bag "allega file" clienti
                    @foreach ($clients as $client)
                    var modalId = "allegafile{{ $client->id }}"; // Costruisci l'ID dinamico
                    var modal = $('#' + modalId);
                    var hasOpenedDueToError =
                    false; // Flag per tracciare se la modalità è stata aperta a causa di errori
                    modal.on('hidden.bs.modal', function(e) {
                        if (hasOpenedDueToError) {
                            location.reload();
                        }
                    });
                @endforeach
                // Apri la modalità solo se ci sono errori specifici per il cliente
                @if ($errors->has('name_file'))
                    modal.modal('show');
                    hasOpenedDueToError = true;
                @endif
            });
</script>

<script>
    setTimeout(function () {
    document.getElementById('success-alert').style.display = 'none';
    }, 5000); 
</script>
@endsection