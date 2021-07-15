@extends('layouts.app')

@section('content')
<div class="container-fluid p-4" style="background-color: white;">
    <!--Tab row-->
    <div class="container">
        <div class="row">
            <div class="col-4">
            
            <h3><a href="/healthworker/chat"><span class="la la-arrow-left"></span></a>
            <span class="mb-0 ml-3">{{$patient->name}} {{$patient->surname}}</span></h3>
            <span class="text-secondary ml-5 small"> View and chat with {{$patient->name}} </span>  
            </div>
            <div class="col-4 text-right py-1">
               
            </div>
            <div class="col-4">
            
            </div>
        </div>
    
    </div>
  
    <!--show chats-->
    <br>
     <div class="container p-3 bg-light rounded-lg border" style="height:350px !important;overflow-y: auto;">
      @foreach($chats as $index => $chat)
      
         <div class="d-flex justify-content-end">
          <div class="p-3"></div>
          <div class="p-3"></div>
          <div class="p-3 text-primary font-weight-bold">{{$chat->sent_message}} <br> 
            @if($chat->sent_message != "")  <span class="small">
              {{ \Carbon\Carbon::parse($chat->created_at)->format('d/m/Y H:m:a')}}
            </span> @endif  </div>
          
        </div>
        <div class="d-flex justify-content-start">
          <div class="p-3 text-secondary font-weight-bold">{{$chat->rec_message}} 
             <br> @if($chat->rec_message != "") <span class="small"> 
              {{ \Carbon\Carbon::parse($chat->created_at)->format('d/m/Y H:m:a')}}
              </span> @endif   </div>
          <div class="p-3"></div>
          <div class="p-3"></div>
        </div>
      @endforeach
     </div>
     <div class="container p-3">
        <form method="POST" action="{{ route('hw-send-chat') }}">
            @csrf
             <!--send the patient's id--> 
             <input type="hidden" name="p_id" value="{{$patient->id}}"/>
           
             <div class="row">
              <div class="col-11">
                <div class="form-group">
                    <div class="form-group">
                        <textarea class="form-control" name="message" rows="3" id="message" placeholder="Enter your message"></textarea>
                      </div>
                   </div>
              </div>  
              <div class="col-1 py-3">
                <div class="form-group mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary rounded-lg">
                          <span>send</span>
                        </button>
                    </div>
                </div>
              </div>
             </div>
            
            
            </form>

     </div>



</div>
@endsection