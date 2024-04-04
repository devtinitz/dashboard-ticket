<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    //

    public function createEvent(Request $request)
    {
        try {

            Log::info('Données reçues : ' . json_encode($request->all()));
            //code...
            $input = $request->all();
            $validator = Validator::make($input,[
                'name'=>'required',
                'code'=>'required',
                'email'=>'required|email',
                'password'=>'required',
                
            ]);

            if($validator->fails()){
                return response()->json([
                    'status'=>false,
                    'message'=> 'Erreur de Validation',
                    'errors'=>$validator->errors()->all(),
                ],422);
            }
        
            $input['password'] =Hash::make($request->password);
            $event = Event::create($input);
            return response()->json([
                'status'=>true,
                'message'=> 'Evenement creer avec succès', 
            ],205);

        } catch (\Exception $th) {
            //throw $th;
            return response()->json([
                'status'=> false,
                'message'=>$th->getMessage()
            ], 501);
        }
    }

   
}