<?php

namespace App\Http\Controllers;

use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Encounter;
use App\Models\EncounterTransfer;

class HealthController extends Controller
{
    //dashboard page
    public function index()
    {
        return view('healthworker/dashboard');
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
        $patients = User::where('role','=','patient')->get();

        /*object showing distinct encounters represented by user's name,age and date the encounter was created
          this object is ordered by most recent dates
        */
        $distinctEncounters = Encounter::Join('users', 'encounters.p_id', '=', 'users.id')
                                        ->groupBy('encounters.p_id')
                                        ->orderBy('encounters.created_at','DESC')
                                        ->distinct()
                                        ->get();

        return view('healthworker/encounter', ['patients' => $patients, 'distinctEncounters' => $distinctEncounters]);
    }
     
    /*page to show individual patient's encounters
    $uid is a variable  representining the patient's id and it is gotten from a GET request
    */
    public function encounterPage($uid){

        $patient = User::find($uid);

        //object carrying all encounter fields relating to a particular user
        $encounters =  Encounter::where('p_id', $uid)->get();

        //object carrying healthworker's info except current user
        $otherHealthWorkers = User::where('id','!=',Auth::id())
                                    ->where('role','=','healthworker')
                                    ->get();

        //object to show sent healthworker's info
                                    

        return view('healthworker/personal-page', ['patient' => $patient, 'encounters' => $encounters, 'otherHealthWorkers'=> $otherHealthWorkers]);
    }

    
    public function patients()
    {


        $patients = User::where('role','=','patient')->get();

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

          $patients = User::where('role','=','patient')->get();

        if($patient->save())
            return redirect()->route('hw_patients')->with('success', 'Carpart added Successfully!');
          
        
        
        }


    public function chat()
    {
        return view('healthworker/chat');
    }

}
