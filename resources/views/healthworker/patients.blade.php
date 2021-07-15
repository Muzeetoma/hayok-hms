@extends('layouts.app')

@section('content')

<div class="container-fluid p-4" style="background-color: white;">
<div class="container">
    <div class="row">
        <div class="col-6">
        <h1>Patients</h1>
        </div>
        <div class="col-6 text-right py-1">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#hayokaddpatient">
                Add Patient
              </button>
        </div>
    </div>

</div>
<br>
<div class="container-fluid table-responsive">
    <input class="form-control" id="hayokInput" type="text" placeholder="Search..">
    <br>
    <!--Table showing patient information-->
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>Image</th>
          <th>Name</th>
          <th>Email</th><th>Surname</th><th>Age</th><th>Gender</th><th>Height</th><th>Weight</th><th>BMI</th>
          <th>Ward</th><th>LGA</th><th>State</th>
        </tr>
      </thead>
      <tbody id="hayokTable">
        @foreach($patients as $patient)
        <tr>
         <td><img src="{{ asset('/images/patients/'.$patient->picture) }}" height="60px" width="60px"></td>
                     
          <td>{{$patient->name}}</td>
          <td>{{$patient->email}}</td>
          <td>{{$patient->surname}}</td>
          <td>{{$patient->age}}</td>
          <td>{{$patient->gender}}</td>
          <td>{{$patient->height}}</td>
          <td>{{$patient->weight}}</td>
          <td>{{$patient->bmi}}</td>
          <td>{{$patient->ward}}</td>
          <td>{{$patient->lga}}</td>
          <td>{{$patient->state}}</td>
        </tr>
        @endforeach
        </tbody>
      </table>

</div>

</div>

<!--start of form to allow entering of patient's data-->


<div class="modal" id="hayokaddpatient">
    <div class="modal-dialog">
      <div class="modal-content">
  
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add Patient</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
  
        <!-- Modal body -->
        <div class="modal-body">
            <div class="container bg-white rounded">
                <h3 class="font-weight-bold">Patient Info</h3>
                <span class="text-secondary">Add the patient's information</span>
                <br><br>
                <form method="POST" action="{{ route('add-patient') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-6">
                            <label class="font-weight-bold w3-medium"></label>Image</label>
                            <br>
                            <div class="custom-file">
                                <input type="file" name="p_image" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                              </div>
            
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold w3-medium">Email</label>
                                <input type="email" name="email" class="form-control" id="pwd">
                              </div>
    
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold w3-medium">Name</label>
                                <input type="text" name="name" class="form-control" id="pwd">
                              </div>
    
                        </div>
                        <div class="col-6 mt-2">
                            <div class="form-group">
                                <label class="font-weight-bold w3-medium">Surname</label>
                                <input type="text" name="surname" class="form-control" id="pwd">
                              </div>
    
                        </div>
                        <div class="col-6 mt-2">
                            <div class="form-group">
                                <label class="font-weight-bold w3-medium">Age</label>
                                <input type="number" name="age" class="form-control" id="pwd">
                              </div>
    
                        </div>
                        <div class="col-6 mt-2">
                            <div class="form-group">
                                <label class="font-weight-bold w3-medium">Gender</label>
                                <select name="gender" class="custom-select">
                                    <option selected>Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
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
                                <label class="font-weight-bold w3-medium">Ward</label>
                                <input type="text" name="ward" class="form-control" id="pwd">
                              </div>
    
                        </div>
                        <div class="col-6 mt-2">
                            <div class="form-group">
                                <label class="font-weight-bold w3-medium">LGA</label>
                                <input type="text" name="lga" class="form-control" id="pwd">
                              </div>
    
                        </div>
                        <div class="col-6 mt-2">
                            <div class="form-group">
                                <label class="font-weight-bold w3-medium">State</label>
                                <input type="text" name="state" class="form-control" id="pwd">
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



<script>
    $(document).ready(function(){
      $("#hayokInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#hayokTable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
    </script>

    <div class="d-flex justify-content-center">
        {!! $patients->links() !!}
    </div>
@endsection