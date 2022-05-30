<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Hash;

class UserController extends Controller
{  
   //USER REGISTER API-POST 
   public function register(Request $request){

     //validation
      $request->validate([
           "name" => "required",
           "email" => "required|email|unique:users",
           "password"=>"required|confirmed",
           "phone_no"=>"required"
       ]);


     //create user data + save

       $user = new User();
       $user->name = $request->name;
       $user->email = $request->email;
       $user->password = bcrypt($request->password);
       $user->phone_no = $request->phone_no ;

       $user->save();

     //send response
     return response()->json([
          "status" => 1,
          "message" => "user registered succesfully"
       ]);

   }
   //USER LOGIN API-POST
   public function login(Request $request){

       //validation
       $request->validate([
           "email" => "required|email",
           "password"=>"required",

       ]);

       // verify user + token
       if (!$token = auth()->attempt(["email" => $request->email, "password" => $request->password])) {

            return response()->json([
                "status" => 0,
                "message" => "Invalid credentials"
            ]);
        }else{

          // send response
        return response()->json([
            "status" => 1,
            "message" => "Logged in successfully",
            "access_token" => $token
        ]);

        }
   }
   //USER PROFILE API-GET
   public function profile(){

      $user_data = auth()->user();

        return response()->json([
            "status" => 1,
            "message" => "User profile data",
            "data" => $user_data
        ]);
   }

   //USER LOGOUT -GET
   public function logout(){

    auth()->logout();

        return response()->json([
            "status" => 1,
            "message" => "User logged out"
        ]);


   } 
}
