<?php

namespace App\Http\Controllers;

use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HealthController extends Controller
{
    //
    public function index()
    {
        return view('healthworker/dashboard');
    }

    public function encounter()
    {
        return view('healthworker/encounter');
    }

    public function patients()
    {


        $patients = User::where('role','=','patient')->get();

        return view('healthworker/patients', ['patients' => $patients]);
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
