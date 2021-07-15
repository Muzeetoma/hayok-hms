@extends('layouts.app')

@section('content')
<div class="container">
    <!--header-->
    <div class="container mt-4">
        <div class="row">
            <div class="col-6">
            <h2>Dashboard</h2>
            </div>
            <div class="col-6 text-right py-1">
              
            </div>
        </div>
    
    </div>
<!--dashboard body to display pie chart-->
<br><br>
<div class="container">
    <div class="row">
        <div class="col-6">
        <h4 class="font-weight-bold">Analysis</h4>
        </div>
        <div class="col-6 text-right py-1">
            
        </div>
    </div>

</div>
<hr>
    <div class="container">
     <div class="row">
         <div class="col-12 col-lg-6 p-5">
            <div class="card shadow-lg rounded-lg">
                <div class="card-body">
                    <div class="chart-container">
                        <div class="chart has-fixed-height" id="pie_basic"></div>
                    </div>
                </div>
            </div>
         </div>
         <div class="col-12 col-lg-6 p-5">
           <div class="card shadow-lg rounded-lg">
                <div class="card-body">
                    <div class="chart-container">
                        <div class="chart has-fixed-height" id="pie_age"></div>
                    </div>
                </div>
            </div>
         </div>
     </div>
    </div>

    <!--dashboard to display patients -->
    <br><hr>
    <div class="container">
        <div class="row">
            <div class="col-6">
            <h4 class="font-weight-bold">Patients</h4>
            </div>
            <div class="col-6 text-right py-1">
                
            </div>
        </div>
    
    </div>
    <br>

<div class="container-fluid table-responsive shadow-lg py-4 rounded-lg">
    <input class="form-control bg-light" id="hayokInput" type="text" placeholder="Search by age, gender, bmi">
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
<br><br>
 
		
   
</div>

<script type="text/javascript">
    var pie_basic_element = document.getElementById('pie_basic');
    if (pie_basic_element) {
        var pie_basic = echarts.init(pie_basic_element);
        pie_basic.setOption({
            color: [
                '#ffa600','#003f5c','#97b552','#95706d','#dc69aa',
                '#59678c','#c9ab00','#7eb00a','#6f5553','#c14089',
                '#2ec7c9','#b6a2de','#5ab1ef','#ffb980','#d87a80',
                '#07a2a4','#9a7fd1','#588dd5','#f5994e','#c05050'
            ],          
            
            textStyle: {
                fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                fontSize: 13
            },
    
            title: {
                text: 'Patients\' Gender Aggregation',
                left: 'center',
                textStyle: {
                    fontSize: 15,
                    fontWeight: 500
                },
                subtextStyle: {
                    fontSize: 12
                }
            },
    
            tooltip: {
                trigger: 'item',
                backgroundColor: 'rgba(0,0,0,0.75)',
                padding: [10, 15],
                textStyle: {
                    fontSize: 13,
                    fontFamily: 'Roboto, sans-serif'
                },
                formatter: "{a} <br/>{b}: {c} ({d}%)"
            },
    
            legend: {
                orient: 'horizontal',
                bottom: '0%',
                left: 'center',                   
                data: ['male','female'],
                itemHeight: 8,
                itemWidth: 8
            },
    
            series: [{
                name: 'Product Type',
                type: 'pie',
                radius: '70%',
                center: ['50%', '50%'],
                itemStyle: {
                    normal: {
                        borderWidth: 0,
                        borderColor: '#fff'
                    }
                },
                data: <?= $gender_data ?>
            }]
        });
    }




    var pie_age_element = document.getElementById('pie_age');
    if (pie_age_element) {
        var pie_age = echarts.init(pie_age_element);
        pie_age.setOption({
            color: [
                '#07a2a4','#9a7fd1','#588dd5','#f5994e','#c05050',
                '#ffa600','#003f5c','#97b552','#95706d','#dc69aa',
                '#2ec7c9','#b6a2de','#5ab1ef','#ffb980','#d87a80',
                '#59678c','#c9ab00','#7eb00a','#6f5553','#c14089'
            ],          
            
            textStyle: {
                fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                fontSize: 13
            },
    
            title: {
                text: 'Patients\' Age Aggregation',
                left: 'center',
                textStyle: {
                    fontSize: 15,
                    fontWeight: 500
                },
                subtextStyle: {
                    fontSize: 12
                }
            },
    
            tooltip: {
                trigger: 'item',
                backgroundColor: 'rgba(0,0,0,0.75)',
                padding: [10, 15],
                textStyle: {
                    fontSize: 13,
                    fontFamily: 'Roboto, sans-serif'
                },
                formatter: "{a} <br/>{b}: {c} ({d}%)"
            },
    
            legend: {
                orient: 'horizontal',
                bottom: '0%',
                left: 'center',                   
                data: <?= $age_terms ?>,
                itemHeight: 8,
                itemWidth: 8
            },
    
            series: [{
                name: 'Product Type',
                type: 'pie',
                radius: '70%',
                center: ['50%', '50%'],
                itemStyle: {
                    normal: {
                        borderWidth: 1,
                        borderColor: '#fff'
                    }
                },
                data: <?= $age_data ?>
            }]
        });
    }



    $(document).ready(function(){
      $("#hayokInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#hayokTable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });

    
    </script>
   

@endsection