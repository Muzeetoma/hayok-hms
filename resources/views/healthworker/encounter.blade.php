@extends('layouts.app')

@section('content')
<div class="container-fluid p-4" style="background-color: white;">
    <!--Tab row-->
    <div class="container">
        <div class="row">
            <div class="col-6">
            <h1>Patients Encounter</h1>
            </div>
            <div class="col-6 text-right py-1">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#hayokaddencounter">
                   <span class="la la-pencil text-light"></span> Add Encounter
                  </button>
            </div>
        </div>
    
    </div>

    <!--Pane Showing received and sent messages-->

    <!-- Nav tabs -->
    <br>
<ul class="nav nav-tabs ml-4">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#All">Recents</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#sent">Sent</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#received">Received</a>
    </li>
  </ul>
  
  <!-- Tab panes -->
  <div class="tab-content">
    <!--Recents pane grouped distinctly-->
    <div class="tab-pane container active" id="All">
     <div class="container mt-5">
     <ul class="list-group list-group-flush">
      @foreach($distinctEncounters as $distinctEncounter)
      <a href="/encounter/page/{{$distinctEncounter->p_id}}" class="list-group-item">
       <div class="row">
        <div class="col-6">
          <div class="d-flex">
          <div class="p-2">
            <img src="{{ asset('/images/patients/'.$distinctEncounter->picture) }}" class="rounded-circle" height="40px" width="40px">
        
          </div>
          <div class="p-2">
          <h5 class="m-0">{{ $distinctEncounter->name }} {{$distinctEncounter->surname}}</h5>
          <span class="text-secondary small">{{ $distinctEncounter->age}} years old</span>
          </div>
          </div>
        
        </div>
        <div class="col-6 text-right">
          <span>{{ \Carbon\Carbon::parse($distinctEncounter->created_at)->format('d/m/Y H:m:a')}}</span>
        </div>
       </div>
 
      </a>
      

      @endforeach
    </ul>
     </div> 
     



    </div>
    <div class="tab-pane container fade" id="sent">...</div>
    <div class="tab-pane container fade" id="received">...</div>
  </div>
    </div>


    
<div class="modal" id="hayokaddencounter">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Encounter</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
          <div class="container bg-white rounded">
              <h3 class="font-weight-bold">Patients</h3>
              <span class="text-secondary">Choose a patient you had an encounter with</span>
              <br><br>
              <div class="list-group list-group-flush">
              @foreach($patients as $patient)
              
              <a href="/encounter/page/{{$patient->id}}" class="list-group-item">
                <span><img src="{{ asset('/images/patients/'.$patient->picture) }}" height="40px" width="40px"></span>
                <span class="ml-2">{{ $patient->name }}</span>
              </a>
              
              @endforeach
            
              </div>
          </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
@endsection