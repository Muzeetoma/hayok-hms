@extends('layouts.appx')

@section('content')
<div class="container-fluid p-4" style="background-color: white;">
<div class="container">
    <div class="row">
        <div class="col-6">
        <h1>Healthworkers</h1>
        <span class="small text-secondary"> select a health worker to chat with</span>
        </div>
        <div class="col-6 text-right py-1">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#hayokaddpatient">
                Add Patient
              </button>
        </div>
    </div>

</div>



  <!--row of healthworkers' contact info-->
  <div class="container mt-5" style="height: 400px !important;overflow-y: auto;">
    <ul class="list-group list-group-flush">
     @forelse($hws as $hw)
     <a href="/patient/chat/{{$hw->id}}" class="list-group-item">
      <div class="row">
       <div class="col-6">
         <div class="d-flex">
        
         <div class="p-2">
         <h5 class="m-0">{{ $hw->name }} {{$hw->surname}}</h5>
         <span class="text-secondary small">{{ $hw->cadre}}</span>
         </div>
         </div>
       
       </div>
       <div class="col-6 text-right">
         <span class="small">Dpartment of {{ $hw->department}}</span>
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
@endsection