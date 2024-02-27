@extends('layouts.admin')
@section('menuLinks')
<div class="row">
    <div class="col-12 my-2">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a> </li>
            <li class="breadcrumb-item"><a href="{{ route('admin.clients.index') }}">Clienti</a> </li>
            <li class="breadcrumb-item">Dettagli</li>
        </ol>
    </div>
</div>
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-end mb-3">
                <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary d-flex align-items-center">
                    <span>Torna alla lista</span>
                    <i class="fa-solid fa-list ml-2"></i>
                </a>
            </div>
            <div class="col-md-3">
                <div class="card card-primary ">
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
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="d-flex justify-content-between my-3">
                                                <h3 class="mt-1 mb-2 h3">File allegati</h3>
                                                @if(count($client->files) > 1)
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-danger d-flex align-items-center" data-toggle="modal" data-target="#deleteAllFile{{$client->id}}">
                                                    <span class="mr-2">elimina tutti i file</span>
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
                                                            <div class="modal-body  m-0 p-0">
                                                                <form action="{{ route('admin.clients.delete_Allfile', $client->id) }}" method="post">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <p class="p-3">Sei sicuro di voler eliminare tutti gli allegati?</p>
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
                                        <div class="col-sm-12">
                                            @if(count($client->files) > 0)
                                            <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example1_info">
                                                <thead>
                                                    <tr>

                                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Nome file</th>
                                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($client->files as $file)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex justify-content-start align-items-center ml-2">
                                                                <i class="fa fa-solid fa-file fa-2x"></i>
                                                                <span class="ml-2">{{ $file->name_file }}</span>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="d-flex ">
                                                                <form action="{{ route('admin.clients.downloadFile', [$client->id, $file->id]) }}" method="get" class="mr-2">
                                                                    @csrf
                                                                    <button title="scarica file" class="btn btn-secondary flex items-center">
                                                                        <i class="fa-solid fa-download"></i>
                                                                    </button>
                                                                </form>
                                                                <!-- Button trigger modal delete -->
                                                                <button type="button" class="btn btn-danger mr-2" data-toggle="modal" data-target="#deleteFile{{$file->id}}">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                </button>
                                                                <!-- Modal -->
                                                                <div class="modal fade" id="deleteFile{{$file->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                                <form action="{{ route('admin.clients.delete_file', [$client->id, $file->id]) }}" method="post">
                                                                                    @csrf
                                                                                    @method('delete')
                                                                                    <p class="p-3">Sei sicuro di voler eliminare {{ $file->name_file }}?</p>
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
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            @else
                                            <div class="text-center">
                                                <span>NON CI SONO FILE</span>
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
