@extends('layouts.app')

@section('content')
<div class="container-fluid p-4" style="background-color: white;">
    <!--Tab row-->
    <div class="container">
        <div class="row">
            <div class="col-6">
            <h2>Patients Encounter</h2>
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
      <a class="nav-link" data-toggle="tab" href="#received">Received</a>
    </li>
  </ul>
  
  <!-- Tab panes -->
  <div class="tab-content">
    <!--Recents pane grouped distinctly-->
    <div class="tab-pane container active" id="All">
     <div class="container mt-5">
     <ul class="list-group list-group-flush">
      @forelse($distinctEncounters as $distinctEncounter)
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
      @empty
      <div class="container border p-3">
       <center>
        <h3>NO RECORD EXISTS</h3>
       </center>
       </div>

      @endforelse
    </ul>
     </div> 
     



    </div>
   

    <!--pane to show all received encounters-->
    <div class="tab-pane container fade" id="received">
      <div class="container p-4">
        @forelse($receivedEncounters as $index => $encounter)
     
      
       <div class="container p-3 my-5 rounded-lg border bg-light">
        <!--sent encounter header-->
        <div class="row pb-3" data-toggle="collapse" data-target="#demo-{{$encounter->id}}">
          <div class="col-4">
            <h6><span class="font-weight-bolder">{{$encounter->name}} {{$encounter->surname}}</span> (patient)</h6>
      
          <span class="text-success"> received from {{$senderNames[$index]}}</span><br></div>
         <div class="col-4"><span class="font-weight-bold">{{$encounter->diagnosis}}</span><span class="small">(Diagnosis)</span></div>
         <div class="col-4  text-right">
         <span class="small">{{ \Carbon\Carbon::parse($encounter->created_at)->format('d/m/Y H:m:a')}}
         </span></div>
        </div>
       
         <!--sent encounter body-->
        <div id="demo-{{$encounter->id}}" class="row collapse pt-3" style="border-top: 1px solid gainsboro;">
        
            <div class="col-3">
           <div class="container">
              <span class="font-weight-bold">Height</span>
              <span>{{$encounter->height}} ft</span>
            </div>
         </div>
            <div class="col-3">
             <div class="container">
                 <span class="font-weight-bold">Weight</span>
                 <span>{{$encounter->weight}} kg</span>
               </div>
            </div>
            <div class="col-3">
             <div class="container">
                 <span class="font-weight-bold">BMI</span>
                 <span>{{$encounter->bmi}}</span>
               </div>
            </div>
            <div class="col-3">
             <div class="container">
                 <span class="font-weight-bold">Visit</span>
                 <span>{{$encounter->ftv_or_rtv}}</span>
               </div>
            </div>
            <div class="col-3 mt-2">
             <div class="container">
                 <span class="font-weight-bold">Blood Pressure</span>
                 <span>{{$encounter->bp}} mmHg</span>
               </div>
            </div>
            <div class="col-3 mt-2">
             <div class="container">
                 <span class="font-weight-bold">Respiratory Rate</span>
                 <span>{{$encounter->rr}}</span>
               </div>
            </div>
            <div class="col-3 mt-2">
             <div class="container">
                 <span class="font-weight-bold">Temperature</span>
                 <span>{{$encounter->temp}}</span>
               </div>
            </div>
            <!--Diagnosis and treatment plan-->
            <div class="col-6 mt-2">
             <div class="container rounded-lg p-3" style="background-color: white;">
                 <span class="font-weight-bold">Complaints</span><br>
                 <p class="">{{$encounter->complaints}}</p>
               </div>
            </div>
            <div class="col-6 mt-2">
             <div class="container rounded-lg p-3" style="background-color: white;">
                 <span class="font-weight-bold">Treatment Plan</span><br>
                 <p class="">{{$encounter->treatment_plan}}</p>
               </div>
            </div>
        </div>
     
        
    </div> 
       @empty
       <div class="container border">
       <center>
        <h3>NO RECORD EXISTS</h3>
       </center>
       </div>
        
        @endforelse
        
      </div>
      
      
    </div>
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