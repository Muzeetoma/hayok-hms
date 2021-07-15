<?php

namespace App\Http\Controllers;

use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Encounter;
use App\Models\EncounterTransfer;
use App\Models\Chat;
class PatientController extends Controller
{
    //

    public function index()
    {
        $patient = User::find(Auth::id());

        return view('patients/records', ['patient' => $patient]);
    }

    //page to see health workers to chat with
    public function chatPage(){
     
        $hws = User::where('role','=','healthworker')->get();

        return view('patients/chat', ['hws' => $hws]);
    }

       //healthworker to chat with a particular patient
       public function chatHw($pid){


        $hw = User::find($pid);

        //object that carries the messages that the logged in healthworker sends
        $sentChats = Chat::select('message as sent_message', 'created_at')
                                  ->where('send_id','=', Auth::id())
                                  ->where('rec_id','=',$pid)->get();

        //object that carries the messages that the logged in healthworker recvieves for that particular patient
        $receivedChats = Chat::select('message as rec_message', 'created_at')
                                  ->where('send_id','=', $pid)
                                  ->where('rec_id','=', Auth::id())->get();


                                             
        //merge the objects
        $allItems = new \Illuminate\Database\Eloquent\Collection;
        $allItems = $allItems->concat($sentChats);
        $allItems = $allItems->concat($receivedChats);

        //sort the objects by date
        $sorted = $allItems->values()->sortBy('created_at');

        $sorted->sort(function ($a, $b) {
            if ($a->total === $b->total) {
                return strtotime($a->created_at) < strtotime($b->created_at);
            }
        
            return $a->total < $b->total;
        });

        return view('patients/personal-chat', ['hw' => $hw, 'chats' => $sorted]);   
    }


    public function sendChat(Request $request){
        //validate all fields
        $this->validate($request, [
        'message' => 'required',
        'h_id' => 'required',
        ]);
        
        $recId = $request->input('h_id');
    
        $chat = new Chat;
        $chat->rec_id = $recId; 
        $chat->message = $request->input('message');
        $chat->send_id = Auth::id();
    
        if($chat->save())
           return redirect()->route('chat-hw', ['hid' => $recId])->with('success', 'SENT');
      
        }
}

