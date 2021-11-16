<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use App\Mail\SendPinMail;
use Illuminate\Support\Facades\Mail;



class AuthController extends Controller
{

    public function first_register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ]);

        $validatedData['password'] = Hash::make($request->password);
        $validatedData['user_role'] = 1;
        $validatedDate['registration_status'] = 1;

        $user = User::create($validatedData);

        $accessToken = $user->generateToken();

        return response(['user' => $user, 'access_token' => $accessToken], 201);
    }

  


    public function register(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ]);

        
        $validatedData['password'] = Hash::make($request->password);

        $users = new User($validatedData);

         


      
            $user_pin=$users->generateRegisterPin();

            Mail::to($validatedData['email'])->send(new SendPinMail($user_pin));

            $users->save();
            return response(['message' => 'Please check your mail for your pin and use it to login'], 200);
        
        
    }

    public function final_user_register(Request $request, $original_pin){

        $pin = $request->pin;
        
        if($original_pin == $pin){
            $user = User::where('pin',$pin)->first();

            $user->registration_status = 1;
            $accessToken = $user->generateToken();

            $update_user = $user->save();

            if($update_user){
                return response(['message' => 'You have now registered successfully','access_token'=>$accessToken], 200);

            }
        }else{
            return response(['message' => 'Your pin is incorrect'], 400);

        }
       
    }


    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'This User does not exist, check your details'], 400);
        }

        $accessToken = auth()->user()->generateToken();

        return response(['user' => auth()->user(), 'access_token' => $accessToken,'token_type'=>'bearer']);
    }

    public function updateUserRole(Request $request,$user_id){
       
        $user_role= $request->user_role;

        $user = User::where('id',$user_id)->first();

        $user->user_role = $user_role;

        $user->save();

        return response(['message' => 'User role updated'], 200);

    }
    public function logout(){
        
        $user = auth()->user();

        if ($user) {
            $user->api_token = null;
            $user->save();
        }

        return response()->json(['data' => 'User logged out.'], 200);
    }

}