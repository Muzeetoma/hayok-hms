@if(count($errors) > 0)
  @foreach($errors->all() as $error)
  <div class="alert alert-danger alert-dismissible" style="position:fixed;width:300px;height:50px;right:15px;top:5px;z-index:2;">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
     {{ $error}}
  </div>
   @endforeach
@endif

@if(session('success'))
<div class="alert alert-success alert-dismissible" style="position:fixed;width:300px;height:50px;right:15px;top:5px;z-index:2;">
     <button type="button" class="close" data-dismiss="alert">&times;</button>
     {{ session('success') }}
  </div>
@endif

@if(session('error'))

 <div class="alert alert-danger alert-dismissible" style="position:fixed;width:300px;height:50px;right:15px;top:5px;z-index:2;">
     <button type="button" class="close" data-dismiss="alert">&times;</button>
     {{ session('error') }}
  </div>
@endif