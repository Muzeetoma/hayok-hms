@extends('layouts.appx')

@section('content')
<div class="container-fluid p-4" style="background-color: white;">
<div class="container">
    <div class="row">
        <div class="col-6">
        <h1>Your Profile</h1>
        <span class="small text-secondary"> View your profile</span>
        </div>
        <div class="col-6 text-right py-1">
          
        </div>
    </div>

</div>

<!--Patient's record-->
      <div class="container-fluid p-3">
          <div class="row">
         <div class="col-12 p-3"><img src="{{ asset('/images/patients/'.$patient->picture) }}" height="60px" width="60px"></div>
                     
          <div class="col-5 mx-3 my-4 bg-light rounded-lg border p-3"><span class="font-weight-bold">Name </span> {{$patient->name}}</div>
          <div class="col-5 mx-3 my-4 bg-light rounded-lg border p-3"><span class="font-weight-bold">Email </span>{{$patient->email}}</div>
          <div class="col-5 mx-3 my-4 bg-light rounded-lg border p-3"><span class="font-weight-bold">Surname </span>{{$patient->surname}}</div>
          <div class="col-5 mx-3 my-4 bg-light rounded-lg border p-3"><span class="font-weight-bold">Age </span>{{$patient->age}}</div>
          <div class="col-5 mx-3 my-4 bg-light rounded-lg border p-3"><span class="font-weight-bold">Gender </span>{{$patient->gender}}</div>
          <div class="col-5 mx-3 my-4 bg-light rounded-lg border p-3"><span class="font-weight-bold">Height </span>{{$patient->height}}</div>
          <div class="col-5 mx-3 my-4 bg-light rounded-lg border p-3"><span class="font-weight-bold">Weight </span>{{$patient->weight}}</div>
          <div class="col-5 mx-3 my-4 bg-light rounded-lg border p-3"><span class="font-weight-bold">BMI </span>{{$patient->bmi}}</div>
          <div class="col-5 mx-3 my-4 bg-light rounded-lg border p-3"><span class="font-weight-bold">Ward </span>{{$patient->ward}}</div>
          <div class="col-5 mx-3 my-4 bg-light rounded-lg border p-3"><span class="font-weight-bold">LGA </span>{{$patient->lga}}</div>
          <div class="col-5 mx-3 my-4 bg-light rounded-lg border p-3"><span class="font-weight-bold">State </span>{{$patient->state}}</div>
          </div>
      </div>
</div>
@endsection