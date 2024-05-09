<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class StudentController extends Controller
{
    //GET ALL
    public function index(){
        $student = Student::all();
        if($student->count()>0){
            return response()->json([
                'status'=> 200,
                'student'=> $student
            ],200); 
        }else{
            return response()->json([
                'status'=> 404,
                'massage' => 'Student Not Found..!!'
            ],404);
        } 
    }


    //SAVE
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'address' => 'required|string|max:50',
            'telNo' => 'required|digits:10',
        ]);
        if($validator -> fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ],422);
        }else{
            $student = Student::create([
                'name'=> $request->name,
                'address' => $request->address,
                'telNo' => $request->telNo,
            ]);
            if($student){
                return response()->json([
                    'status' => 200,
                    'massage' => 'Student Added Successfully',
                ],200);
            }else{
                return response()->json([
                    'status' => 500,
                    'massage' => 'Somthing Wrong!!',
                ],500);
            }
        }
    }


    //GET STUDENT BY ID
    public function show($id){
        $student= Student::find($id);
        if($student){
            return response()->json([
                'status'=>200,
                'student'=>$student,
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'messege'=>'invalid Id !!',
            ],404);
        }
    }


    //UPDATE STUDENT
    public function update(Request $request, int $id){
        $student=Student::find($id);
        if($student){
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:50',
                'address' => 'required|string|max:50',
                'telNo' => 'required|digits:10',
            ]);
            if($validator -> fails()){
                return response()->json([
                    'status' => 422,
                    'errors' => $validator->messages()
                ],422);
            }else{
                $student->update([
                    'name'=> $request->name,
                    'address' => $request->address,
                    'telNo' => $request->telNo,
                ]);
                if($student){
                    return response()->json([
                        'status' => 200,
                        'massage' => 'Student Added Successfully',
                    ],200);
                }else{
                    return response()->json([
                        'status' => 500,
                        'massage' => 'Somthing Wrong!!',
                    ],500);
                }
            }
        }else{
            return response()->json([
                'status' =>404,
                'message' =>'Student Not found..!!'
            ],404);
        }  
    
    }


    //DELETE STUDENT
    public function destroy($id){
        $student = Student::find($id);
        if($student){
            $student->delete();
            return response()->json([
                'status' =>200,
                'message' =>$id.' Student Deleted..!!'
            ],200);
        }else{
            return response()->json([
                'status' =>404,
                'message' =>'Student Not found..!!'
            ],404);
        }
    }
}
