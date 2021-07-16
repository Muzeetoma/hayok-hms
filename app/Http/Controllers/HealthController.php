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

class HealthController extends Controller
{
    //dashboard page
    public function index()
    {

        //get gender aggregation
        $agg_genders = User::select('gender', DB::raw('count(*) as total'))
                            ->where('role','=','patient')
                            ->groupby('gender')
                            ->get();

        //get age aggregation
        $agg_ages = User::select('age', DB::raw('count(*) as total'))
        ->where('role','=','patient')
        ->groupby('age')
        ->get();

        $genderPoints = [];
        $agePoints = [];

        foreach($agg_genders as $agg_gender){

            $genderPoints[] = array(
                "name" => $agg_gender['gender'],
                "value" => $agg_gender['total'],
            );
        }
        
        
        foreach($agg_ages as $agg_age){

            $agePoints[] = array(
                "name" => $agg_age['age'],
                "value" => $agg_age['total']
            );
        }

        //get patients
        $patients = User::where('role','=','patient')->get();

        return view('healthworker/dashboard', [ 'gender_data' => json_encode($genderPoints), 'gender_terms' => json_encode(array(
            "Male","Female"
        )), 'age_data' => json_encode($agePoints), 'age_terms' => json_encode($agePoints), 'patients' => $patients
        ]);
    }

    
    /*
    <p_id> represents patient_id on the encounters table 
    while it is represented as a combination of id and role=patients on the users table 
    <u_id> represents user_id on the encounters table
    while it is represented as a combination of id and role=healthworker on the users table  
    */


    //page to show all,sent and received encounters
    public function encounter()
    {
        //show all patients regardless so the logged in user can select any patient to record an ecounter
        $patients = User::where('role','=','patient')->get();

        /*object showing distinct encounters represented by user's name,age and date the encounter was created
          this object is ordered by most recent dates
          all records are those that were recorded by the logged in healthworker
        */
        $distinctEncounters = Encounter::Join('users', 'encounters.p_id', '=', 'users.id')
                                        ->where('encounters.u_id','=', Auth::id())
                                        ->groupBy('encounters.p_id')
                                        ->orderBy('encounters.created_at','DESC')
                                        ->distinct()
                                        ->get();
        
        //object to show received encounters to the logged in healthworker orderd by recents
        $receivedEncounters = EncounterTransfer::join('encounters', 'encounter_transfers.e_id', '=','encounters.id')
                                                ->join('users', 'encounters.p_id', '=','users.id')
                                                ->where('encounter_transfers.r_id','=', Auth::id())
                                                ->orderBy('encounter_transfers.created_at','DESC')
                                                ->get();
        //extract the sender ids and add to senderNames array  
        $receivedFrom = null;
         
        $senderNames = array();
         //loop across each sender name and add to the sendernames array 
        foreach($receivedEncounters as $receivedEncounter){
            $receivedFrom = User::find($receivedEncounter->s_id);
            array_push($senderNames,$receivedFrom->name.' '.$receivedFrom->surname);
          
        }

        return view('healthworker/encounter', ['patients' => $patients, 'senderNames' => $senderNames, 'receivedEncounters' => $receivedEncounters, 'distinctEncounters' => $distinctEncounters]);
    }
     
    /*page to show individual patient's encounters
    $uid is a variable  representing the patient's id and it is gotten from a GET request
    */
    public function encounterPage($uid){

        $patient = User::find($uid);

        //object carrying all encounter fields relating to a particular patient and recorded by the logged in healthworker
        $encounters =  Encounter::where('p_id', $uid)
                                 ->where('u_id', Auth::id())
                                 ->paginate(3);

        //object carrying healthworker's info except current user
        $otherHealthWorkers = User::where('id','!=',Auth::id())
                                    ->where('role','=','healthworker')
                                    ->get();

       


        return view('healthworker/personal-page', ['patient' => $patient, 'encounters' => $encounters, 'otherHealthWorkers'=> $otherHealthWorkers]);
    }

    
    public function patients()
    {


        $patients = User::where('role','=','patient')->paginate(4);

        return view('healthworker/patients', ['patients' => $patients]);
    }

    //function to forward encounter to another health worker
    public function forwardEncounter(Request $request){
     //validate all fields
     /*
      <e_id> stands for the encounter id
      <s_id> stands for the sender id
      <r_id> stands for the receiver id
     */
     $this->validate($request, [
        'p_id' => 'required',
        'r_id' => 'required',
        'e_id' => 'required',
      ]);

      $senderId = Auth::id();
      $patientId = $request->input('p_id');
      $receiverId = $request->input('r_id');
      $encounterId = $request->input('e_id');

      //check for an existing forwarded message

      $isExists = EncounterTransfer::where('s_id', $senderId)
                                    ->where('r_id', $receiverId)
                                    ->where('e_id', $encounterId)->first();

      //if a forwarded message already exists dont send again  
      if($isExists != null)
          return redirect()->route('encounter-page', ['uid' => $patientId])->with('error', 'Message already forwarded!');
       else {

        $encounterTransfer = new EncounterTransfer;
        $encounterTransfer->s_id = $senderId;
        $encounterTransfer->r_id = $receiverId;
        $encounterTransfer->e_id = $encounterId;

        if($encounterTransfer->save())
        return redirect()->route('encounter-page', ['uid' => $patientId])->with('success', 'Message forwarded!');
           
       } 
                            
      
    
    }

    public function addEncounter(Request $request){
        //validate all fields
        $this->validate($request, [
            'u_id' => 'required',
            'p_id' => 'required',
            'ftv_or_rtv' => 'required',
            'weight' => 'required',
            'height' => 'required',
            'bp' => 'required',
            'temp' => 'required',
            'rr' => 'required',
            'diagnosis' => 'required',
            'complaints' => 'required',
            'treatment_plan' => 'required',
          ]);

          $height = $request->input('height');
          $weight = $request->input('weight');
          $bmi = $weight/$height;
          $p_id = $request->input('p_id');

          $encounter = new Encounter;
          $encounter->u_id = $request->input('u_id');
          $encounter->p_id = $p_id;
          $encounter->ftv_or_rtv = $request->input('ftv_or_rtv');
          $encounter->height = $height;
          $encounter->weight = $weight;
          $encounter->bmi = $bmi;
          $encounter->bp = $request->input('bp');
          $encounter->temp = $request->input('temp');
          $encounter->rr = $request->input('rr');
          $encounter->complaints = $request->input('complaints');
          $encounter->diagnosis = $request->input('diagnosis');
          $encounter->treatment_plan = $request->input('treatment_plan');

          if($encounter->save())
            return redirect()->route('encounter-page', ['uid' => $p_id])->with('success', 'Encounter added Successfully!');
        
          
    }

    public function addPatient(Request $request){

        $this->validate($request, [
            'p_image' => 'required|image|nullable|max:1999',
            'email' => 'required',
            'name' => 'required',
            'surname' => 'required',
            'age' => 'required',
            'gender' => 'required',
            'height' => 'required',
            'weight' => 'required',
            'ward' => 'required',
            'lga' => 'required',
            'state' => 'required',
            'password' => 'required',
          ]);

          if($request->hasFile('p_image')){

            $p_image = $request->file('p_image');

            $filenameWithExt = $request->file('p_image')->getClientOriginalName();

            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            $extension = $request->file('p_image')->getClientOriginalExtension();

            $fileNameToStore = $filename .'_'.time().'.'.$extension;

            //$path = $request->file('p_image')->storeAs('public/carparts', $fileNameToStore);
            $destinationPath = public_path('images/patients/');
            $p_image->move($destinationPath, $fileNameToStore);
        

        }else{
            $fileNameToStore = 'noimage.png';
        }

          $height = $request->input('height');
          $weight = $request->input('weight');
          $bmi = $weight/$height;
          $role = "patient";


          $patient = new User;
          $patient->picture = $fileNameToStore;
          $patient->name = $request->input('name');
          $patient->surname = $request->input('surname');
          $patient->email = $request->input('email');
          $patient->age = $request->input('age');
          $patient->gender = $request->input('gender');
          $patient->weight = $request->input('weight');
          $patient->height = $request->input('height');
          $patient->ward = $request->input('ward');
          $patient->bmi = $bmi;
          $patient->role = $role;
          $patient->lga = $request->input('lga');
          $patient->state = $request->input('state');
          $patient->password = $request->input('password');

          $patients = User::where('role','=','patient')->get();

        if($patient->save())
            return redirect()->route('hw_patients')->with('success', 'Details added Successfully!');
          
        
        
        }


    public function chatPage()
    {

        $patients = User::where('role','=','patient')->get();

        return view('healthworker/chat', ['patients' => $patients]);
    }

    //healthworker to chat with a particular patient
    public function chatPatient($pid){


        $patient = User::find($pid);

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

        return view('healthworker/personal-chat', ['patient' => $patient, 'chats' => $sorted]);   
    }

    public function sendChat(Request $request){
    //validate all fields
    $this->validate($request, [
    'message' => 'required',
    'p_id' => 'required',
    ]);
    
    $recId = $request->input('p_id');

    $chat = new Chat;
    $chat->rec_id = $recId; 
    $chat->message = $request->input('message');
    $chat->send_id = Auth::id();

    if($chat->save())
       return redirect()->route('hw_chat_patient', ['pid' => $recId])->with('success', 'SENT');
  
    }

}
