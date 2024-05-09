<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Throwable;

class UserController extends Controller
{
    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:50',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
            ]);
            if($validator -> fails()){
                return response()->json([
                    'status' => 422,
                    'errors' => $validator->messages()
                ],422);
            }else{
                $user = User::create([
                    'name'=> $request->name,
                    'email' => $request->email,
                    'password' => $request->password,
                ]);
                if($user){
                    
                    return response()->json([
                        'status' => 200,
                        'massage' => 'Student Added Successfully',
                        'token' =>$user->createToken('API_TOKEN')->plainTextToken
                    ],200);
                }else{
                    return response()->json([
                        'status' => 500,
                        'massage' => 'Somthing Wrong!!',
                    ],500);
                }
            }
        }catch(\Throwable $th){
            return response()->json([
                'status'=>500,
                'massage'=>$th->getMessage(),
            ],500);
        }
    }

    public function logIn(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if($validator -> fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ],422);
        }
        $userEmail = User::where('email', $request->email)->first();
        if(!$userEmail||($userEmail->password!=$request->password)){
            return response()->json([
                'status' => false,
                'message' => 'Email & Password does not match with our record.',
            ], 401);
        }
        $user=User::where('email', $request->email)->first();
        
        return response()->json([
            'status' => true,
            'message' => 'User Logged In Successfully',
            'token' => $user->createToken('API_TOKEN')->plainTextToken,
        ], 200);
    }

    public function logOut(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status'=>200,
            'massege'=>'LogOut!!'
        ],200);
    }
}