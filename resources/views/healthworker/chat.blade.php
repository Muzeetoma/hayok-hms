@extends('layouts.app')

@section('content')
<div class="container-fluid p-4" style="background-color: white;">
    <!--status bar row-->
    <div class="container">
        <div class="row">
            <div class="col-6">
            <h2 class="my-0">Chats</h2>
            <span class="small text-secondary">Select patients to chat with</span>
            </div>
            <div class="col-6 text-right py-1">
                
            </div>
        </div>
    
    </div>


    <!--row of patients' contact info-->
    <div class="container mt-5" style="height: 400px !important;overflow-y: auto;">
        <ul class="list-group list-group-flush">
         @forelse($patients as $patient)
         <a href="/healthworker/chat/{{$patient->id}}" class="list-group-item">
          <div class="row">
           <div class="col-6">
             <div class="d-flex">
             <div class="p-2">
               <img src="{{ asset('/images/patients/'.$patient->picture) }}" class="rounded-circle" height="40px" width="40px">
           
             </div>
             <div class="p-2">
             <h5 class="m-0">{{ $patient->name }} {{$patient->surname}}</h5>
             <span class="text-secondary small">{{ $patient->age}} years old</span>
             </div>
             </div>
           
           </div>
           <div class="col-6 text-right">
             <span>{{ \Carbon\Carbon::parse($patient->created_at)->format('d/m/Y H:m:a')}}</span>
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