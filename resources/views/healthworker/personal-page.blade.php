@extends('layouts.app')

@section('content')
<div class="container-fluid p-4" style="background-color: white;">
    <!--Tab row-->
    <div class="container">
        <div class="row">
            <div class="col-4">
            
            <h3><a href="/healthworker/encounter"><span class="la la-arrow-left"></span></a>
            <span class="ml-3">{{$patient->name}} {{$patient->surname}}</span></h3>
            <span class="text-secondary ml-5 small">View, add and forward {{$patient->name}}'s personal records </span>  
            </div>
            <div class="col-4 text-right py-1">
               
            </div>
            <div class="col-4">
            
            </div>
        </div>
    
    </div>
     <!--view of the personal encounter records-->
    <div class="container my-4">


       @forelse($encounters as $encounter)
       <div class="container p-3 my-5 rounded-lg bg-light border">
           <!--encounter header-->
           <div class="row">
            <div class="col-6"><span class="font-weight-bold">{{$encounter->diagnosis}}</span><span class="small">(Diagnosis)</span></div>
            <div class="col-6  text-right">
            <span class="small">{{ \Carbon\Carbon::parse($encounter->created_at)->format('d/m/Y H:m:a')}}
            </span></div>
           </div>
           <hr>

           <div class="row">
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
           <!--button to forward patient's record-->
           <div class="container-fluid text-right mt-2">
           <button class="btn btn-success px-2 py-0" data-toggle="collapse" data-target="#demo-{{$encounter->id}}"><span class="small">forward</span> <span class="la la-arrow-right"></span></button>
           </div>
            
          <div id="demo-{{$encounter->id}}" class="collapse" style="width:40%">
           <form method="POST" action="{{ route('forward-encounter') }}">
           @csrf
             <!--send the encounter id-->
            <input type="hidden" name="e_id" value="{{$encounter->id}}"/>
            <!--send the patient's id--> 
            <input type="hidden" name="p_id" value="{{$patient->id}}"/>
            <!--send the healthworker's id-->
            <div class="form-group">
                <label class="font-weight-bold w3-medium">Choose Healthworker to forward to</label>
                <select name="r_id" class="custom-select" required>
                    
                    @foreach($otherHealthWorkers as $otherHealthWorker)
                    <option value="{{$otherHealthWorker->id}}">{{$otherHealthWorker->name}} {{$otherHealthWorker->surname}}</option>
                    @endforeach
                  </select>
              </div>
              <div class="form-group mb-0">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">
                      <span>send</span>
                    </button>
                </div>
            </div>
           </form>
           </div>

       </div> 

       @empty
       <div class="container">
        <center>
          <h4 class="p-3 border">NO RECORD EXISTS</h4>
        </center>
        </div>


       @endforelse



        <!--Button to add encounter for a specific patient-->
        <button class="btn btn-primary p-3 rounded-circle shadow"  data-toggle="modal" data-target="#hayokaddencounter" style="position:fixed;bottom:55px;right:55px;">
            <span class="la la-pencil" style="font-size: 30px;"></span>
            </button>
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
                    <h3 class="font-weight-bold">Add an encounter</h3>
                    <span class="text-secondary">Write an encounter you had with {{$patient->name}}</span>
                    <br><br>
                    <form method="POST" action="{{ route('add-encounter') }}">
                        @csrf
                        <!--the patient's ID and user id are sent to the encounters table-->
                        <input type="hidden" name="p_id" value="{{$patient->id}}"/>
                        <input type="hidden" name="u_id" value="{{ Auth::user()->id }}"/>

                        <div class="row">
                            <div class="col-6 mt-2">
                                <div class="form-group">
                                    <label class="font-weight-bold w3-medium">First time visit or Repeat visit
                                    </label>
                                    <select name="ftv_or_rtv" class="custom-select">
                                        <option selected>Select Option</option>
                                        <option value="first time visit">First Time Visit</option>
                                        <option value="repeat visit">Repeat Visit</option>
                                      </select>
                                  </div>
        
                            </div>
                            <div class="col-6 mt-2">
                                <div class="form-group">
                                    <label class="font-weight-bold w3-medium">Weight</label>
                                    <input type="number" name="weight" class="form-control" id="pwd">
                                  </div>
        
                            </div>
                            <div class="col-6 mt-2">
                                <div class="form-group">
                                    <label class="font-weight-bold w3-medium">Height</label>
                                    <input type="number" name="height" class="form-control" id="pwd">
                                  </div>
        
                            </div>
                            <div class="col-6 mt-2">
                                <div class="form-group">
                                    <label class="font-weight-bold w3-medium">Blood Pressure</label>
                                    <input type="number" name="bp" class="form-control" id="pwd">
                                  </div>
        
                            </div>
                            <div class="col-6 mt-2">
                                <div class="form-group">
                                    <label class="font-weight-bold w3-medium">Temperature</label>
                                    <input type="number" name="temp" class="form-control" id="pwd">
                                  </div>
        
                            </div>
                            <div class="col-6 mt-2">
                                <div class="form-group">
                                    <label class="font-weight-bold w3-medium">Respiratory Rate</label>
                                    <input type="number" name="rr" class="form-control" id="pwd">
                                  </div>
        
                            </div>
                            <div class="col-6 mt-2">
                                <div class="form-group">
                                    <label class="font-weight-bold w3-medium">Diagnosis
                                    </label>
                                    <select name="diagnosis" class="custom-select">
                                        <option selected>Select Option</option>
                                        <option value="hypertension">Hypertension</option>
                                        <option value="pneumonia">Pneumonia</option>
                                        <option value="malaria">Malaria</option>
                                        <option value="diabetes">Diabetes</option>
                                      </select>
                                  </div>
        
                            </div>
                            <div class="col-6 mt-2">
                                <div class="form-group">
                                    <label class="font-weight-bold w3-medium">Complaints Box</label>
                                    <textarea name="complaints" class="form-control" id="pwd"></textarea>
                                  </div>
        
                            </div>
                            <div class="col-6 mt-2">
                                <div class="form-group">
                                    <label class="font-weight-bold w3-medium">Treatment Plan</label>
                                    <textarea name="treatment_plan" class="form-control" id="pwd"></textarea>
                                  </div>
        
                            </div>
                        
                        </div>
                        <div class="form-group mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success btn-block">
                                    {{ __('ADD') }}
                                </button>
                            </div>
                        </div>
                        </form>
                </div>
            </div>
      
            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
      
          </div>
        </div>
      </div>

      <div class="d-flex justify-content-center">
        {!! $encounters->links() !!}
    </div>
@endsection