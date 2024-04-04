<?php

namespace App\Http\Controllers\Api;


use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    public function login(Request $request)
    {
        try {
            //code...
            $input = $request->all();
            $validator = Validator::make($input,[
                'code'=>'required|code',
                'password'=>'required',
            ]);

            if($validator->fails()){
                return response()->json([
                    'status'=>false,
                    'message'=> 'Erreur de Validation',
                    'errors'=>$validator->errors()->all(),
                ],422);
            }
             // verifie si les information saisies corrspondent aux info de la bd
            if(!Auth::attempt($request->only('email', 'password'))){
                return response()->json([
                    'status'=>false,
                    'message'=> 'email ou mot de passe incorrect',
                    'errors'=>$validator->errors(),
                ],401);
            }
            $user = User::where('email', $request->email)->first();
            return response()->json([
                'status'=>true,
                'message'=> 'Utilisateur connecté avec succès',
                'data'=> [
                    'token'=> $user->createToken('auth_user')->plainTextToken,
                    'token_type'=> "Bearer"
                ]
            ]);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status'=> false,
                'message'=>$th->getMessage()
            ], 500);
        }
    }

    public function register(Request $request){

        try {
            //code...
            $input = $request->all();
            $validator = Validator::make($input,[
                'email'=>'required|email|unique:users,email',
                'password'=>'required|confirmed',
                'password_confirmation'=>'required',
            ]);

            if($validator->fails()){
                return response()->json([
                    'status'=>false,
                    'message'=> 'Erreur de Validation',
                    'errors'=>$validator->errors(),
                ],422);
            }
        
            $input['password'] =Hash::make($request->passord);
            $user = User::create($input);
            return response()->json([
                'status'=>true,
                'message'=> 'Utilisateur creer avec succès',
                'data'=> [
                    'token'=> $user->createToken('auth_user')->plainTextToken,
                    'token_type'=> "Bearer"
                ]
            ]);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status'=> false,
                'message'=>$th->getMessage()
            ], 500);
        }
    }
}
