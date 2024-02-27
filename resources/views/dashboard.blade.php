  @extends('layouts.admin')
  @section('menuLinks')
  <div class="row">
      <div class="col-12 my-2">
          <ol class="breadcrumb ">
              <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a> </li>
          </ol>
      </div>
  </div>
  @endsection
  @section('content')
  <div class="container-fluid">
      <div class="row">
          <div class="col-3">
              <div class="small-box bg-warning">
                  <div class="inner">
                      <h3>{{count($clients)}}</h3>

                      <p>Clienti in lista</p>
                  </div>
                  <div class="icon">
                      <i class="ion ion-person-add"></i>
                  </div>
                  <a href="{{route('admin.clients.index')}}" class="small-box-footer">Vai alla tua lista <i class="fas fa-arrow-circle-right"></i></a>
              </div>
          </div>
          <div class="col-3">
              <div class="small-box bg-info">
                  <div class="inner">
                      <h3>{{count($todos)}}</h3>

                      <p>Note personali</p>
                  </div>
                  <div class="icon">
                    <i class="fa-solid fa-note-sticky ml-1 mr-2"></i>
                  </div>
                  <a href="{{route('admin.todos.index')}}" class="small-box-footer">Vai alle tue note <i class="fas fa-arrow-circle-right"></i></a>
              </div>
          </div>
      </div>
  </div>
  @endsection
