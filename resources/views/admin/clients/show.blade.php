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
            <div class="col-2">
                <div class="card overflow-hidden d-flex justify-content-center">
                    @if($client->file_url)
                    <figure>
                        <img src="{{asset('storage/' . $client->file_url)}}" 
                           class="rounded p-0 img-fluid"
                            alt="img">
                    </figure>
                    @else
                    <figure class="overflow-hidden p-0">
                        <img src="{{asset('imgs/placeholder.png')}}" 
                            class="rounded p-0 img-fluid"
                            alt="img">
                    </figure>
                    @endif
                    <h3 class="profile-username text-center mb-4">{{Str::upper($client->name_client)}}
                        {{Str::upper($client->surname_client)}}</h3>
                </div>
            </div>
            <div class="col-10">
                <div class="card card-primary ">
                    <div class="card-body box-profile">
                        <div class="d-flex justify-content-between align-items-center mb-3">

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
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body m-0 p-0">
                                            <form action="{{ route('admin.clients.update', $client->id) }}"
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
                        </div>


                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-bold">Data di nascita</span> <span>{{ $client->date_of_birth ?? '-'
                                    }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-bold">Città di nascita</span> <span>{{ $client->city_of_birth ?? '-'
                                    }} </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-bold">Indirizzo</span> <span>{{ $client->address ?? '-' }} </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-bold">CAP</span> <span>{{ $client->cap ?? '-' }} </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-bold">File allegati</span> <span>{{ count($client->files) }} </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-bold">Appunti</span> <span>{{ count($client->notes) }} </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@section('additionalscripts')

{{-- mostra tag input dopo inserimento immagine --}}
<script>
    const urlFile = document.getElementById('url_file');
    urlFile.addEventListener('input', function (e) {
        const nameFIle = document.getElementById('fileName');
        const file = urlFile.value;
        console.log(file);
        trueDis = urlFile.disabled = false;
        nameFIle.style.display = file !== '' ? 'block' : 'none';
    });
</script>
@endsection