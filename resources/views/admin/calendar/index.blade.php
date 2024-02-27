@extends('layouts.admin')
@section('menuLinks')
<div class="row">
    <div class="col-12 my-2">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a> </li>
            <li class="breadcrumb-item">Calendario</li>
        </ol>
    </div>
</div>
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary d-flex align-items-center" data-toggle="modal"
                    data-target="#ModalCreateCalendar">
                    <span class="mr-2">Crea evento</span>
                    <i class="fa-solid fa-plus fa-2x"></i>
                </button>
                <!-- Modal create-->
                <div class="modal fade" id="ModalCreateCalendar" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Crea evento</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class=" ">
                                @include('admin.partials.errors')
                            </div>
                            <div class="modal-body">
                                <form action="{{route('admin.calendar.store')}}" method="POST" class="form-group">
                                    @csrf

                                    <div class="mt-3 ">
                                        <label for="title">Titolo</label>
                                        <input type="text" name="title"
                                            class="form-control  @error('title') border border-danger @enderror" />
                                    </div>
                                    @error('title')
                                    <span>{{$message}}</span>
                                    @enderror
                                    <div class="mt-3">
                                        <label for="description">Descrizione</label>
                                        <textarea rows="5" id="description" name="description"
                                            class="form-control"></textarea>
                                    </div>
                                    <div class="mt-3">
                                        <label for="start">Inizio</label>
                                        <input type="datetime-local" name="start"
                                            value='{{ now()->toDateTimeString() }}' id="start" class="form-control">
                                    </div>
                                    <div class="mt-3">
                                        <label for="end">Fine</label>
                                        <input type="datetime-local" name="end" value='{{ now()->toDateTimeString() }}'
                                            id="end" class="form-control">
                                    </div>

                                    <div class="pt-5 text-end">
                                        <button type="submit" class="btn btn-secondary">
                                            Crea </button>
                                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>

                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>


                @foreach($user->appointments as $appointment)
                <!-- Modal confirm-->
                <div class="modal fade" id="confirmDelete{{$appointment->id}}" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Attenzione</h5>
                                <button id="closeBtnX{{$appointment->id}}" type="button" class="close"
                                    data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Sei sicuro di eliminare l'evento "{{ $appointment->title }}"?

                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-danger" id="deleteBtn{{$appointment->id}}">Elimina</button>
                                <button class="btn btn-light" type="button" id="closeBtn{{$appointment->id}}"
                                    data-dismiss="modal" aria-label="Close">Chiudi</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
            <div class="col-12">
                <div style="height: 15px; margin: 8px 0">
                    @include('admin.partials.messages')
                </div>
            </div>
            <div class="col-12">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</section>
@endsection


@section('additionalscripts')
{{-- FULLCALENDAR --}}
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    const calendarEl = document.getElementById('calendar');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        timeZone: 'UTC',
        events: `/admin/calendar/getAppointments`,
        dayMaxEvents: true,
        editable: true,
        selectable: true,
        eventResizableFromStart: true,
        locale: 'it',

        eventContent: function(info) {
            let eventTitle = info.event.title;
            const eventElement = document.createElement('div');
            eventElement.style.display = 'inline-flex';
            eventElement.style.width = '100%';
            eventElement.style.justifyContent = 'space-between';

            eventElement.innerHTML = `<span>
                ${eventTitle } 
                </span>
                 <div class="flex">
                <span class="spanDelete" title="elimina">
                    <i class="fa-solid fa-trash"></i>
                 </span>
                <span class="editInfo mx-2" title="modifica">
                    <i class="fa-solid fa-edit"></i>
                 </span>
                <span class="detailInfo" title="dettagli">
                    <i class="fa-solid fa-eye"></i>
                 </span>
                   </div>`;

         
            //delete
            eventElement.querySelector('.spanDelete').addEventListener('click', function() {
                 const appointment = info.event.id;
                const deleteBtn = document.getElementById('deleteBtn' + appointment)
    
                 $('#confirmDelete'+ appointment).modal('show');
                 $('#closeBtn' + appointment).modal('hide');
                 $('#closeBtnX' + appointment).modal('hide');
                    
                    deleteBtn.addEventListener('click', function() {
                    $.ajax({
                        method: 'DELETE',
                        url: `/admin/calendar/${appointment}`,
                        success: function(response) {
                            $('#confirmDelete' + appointment).modal('hide');
                            calendar.refetchEvents();
                            if(response.message){
                                const modalAlertJson = document.getElementById('modalAlertJson');
                                modalAlertJson.classList.remove('d-none');
                                modalAlertJson.innerHTML = response.message;
                                 setTimeout(() => {
                                    modalAlertJson.classList.add('d-none');
                                    modalAlertJson.innerHTML = '';
                                }, 5000);
                             }
                    },
                    error: function(error) {
                        console.log('errore: ', error);

                    }
                });
             });

            });
          
            //edit
            eventElement.querySelector('.editInfo').addEventListener('click', function() {
               const appointment = info.event.id;
                $.ajax({
                    method: 'GET'
                    , url: `/admin/calendar/${appointment}/edit`
                    
                    , success: function(response) {
                        document.querySelector('body').innerHTML = response;
                        const newUrl = `${window.location.origin}/admin/calendar/${appointment}/edit`;
                        history.pushState({}, '', newUrl);
                    }
                    , error: function(error) {
                        console.log(error);
                    }
                });
            });

            //detail
            eventElement.querySelector('.detailInfo').addEventListener('click', function() {
               const appointment = info.event.id;
                $.ajax({
                    method: 'GET'
                    , url: `/admin/calendar/${appointment}/detail`
                    
                    , success: function(response) {
                        document.querySelector('body').innerHTML = response;
                        const newUrl = `${window.location.origin}/admin/calendar/${appointment}/detail`;
                        history.pushState({}, '', newUrl);
                    }
                    , error: function(error) {
                        console.log(error);
                    }
                });
            });
            
            return {
                domNodes: [eventElement]
            };
        },

         //drag e drop events (update date event)
        eventDrop: function(info) {
          var appointment = info.event.id;
         var newStartDate = info.event.start;
         var newEndDate = info.event.end || newStartDate;
         var newStartDateUTC = newStartDate.toISOString().slice(0, 10);
          var newEndDateUTC = newEndDate.toISOString().slice(0, 10);
     
            $.ajax({
            method: 'PUT'
            , url: `/admin/calendar/${appointment}/dateUpdate`
            , data: {
                start: newStartDateUTC
                , end: newEndDateUTC
            , }
            , success: function(response) {
                 
                if(response.message){
                        const modalAlertJson = document.getElementById('modalAlertJson');
                        modalAlertJson.classList.remove('d-none');
                        modalAlertJson.innerHTML = response.message;
                            setTimeout(() => {
                                modalAlertJson.classList.add('d-none');
                                modalAlertJson.innerHTML = '';
                            }, 5000);
                }

            }
            , error: function(error) {
                console.log(error);
            }
        });
    }

    });

    calendar.render();
</script>

{{-- ERROR BAG --}}
<script>
    $(document).ready(function() {
         //mostra error bag form "titolo" pagina calendario  
        $('#ModalCreateCalendar').on('hidden.bs.modal', function() {
            // Ricarica la pagina se la modale è stata chiusa senza essere confermata
            location.reload();
        });
       @if($errors->has('title')) 
        $('#ModalCreateCalendar').modal('show');
       @endif  
    })
</script>



<script>
    setTimeout(function () {
    document.getElementById('success-alert').style.display = 'none';
    }, 5000); 
</script>
@endsection