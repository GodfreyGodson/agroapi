<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Helper\Helper;
use App\Models\Otp;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(Request $request){

        $fields = $request ->validate([

            'first_name'=>'required|string',
            'last_name'=>'required',
            'phone_number'=>'required',
            'gender'=>'required',
            'email'=>'required|string|unique:users,email',
            'id_number'=>'required',
            'id_type'=>'required',
            'location'=>'required',
            'password'=>'required|string|confirmed'
        ]);

        $user = User::create([
            'first_name'=>$fields['first_name'],
            'last_name'=>$fields['last_name'],
            'phone_number'=>$fields['phone_number'],
            'gender'=>$fields['gender'],
            'email'=>$fields['email'],
            'id_number'=>$fields['id_number'],
            'id_type'=>$fields['id_type'],
            'location'=>$fields['location'],
            'password'=>bcrypt($fields['password']),

        ]);
        $otp = rand(0000,9999);
        if($otp<10){
            $otp = '000'.$otp;
        }else if($otp<100){
            $otp = '00'.$otp;
        }else if($otp<1000){
            $otp ='0'.$otp;
        }else{
            $otp = $otp;
        }

        //$otp = "7846";

        Otp::create([
            'email'=>$user->email,
            'otp'=>Hash::make($otp),
        ]);
        $message = $otp.' is verification code for http://agrolives.co.tz';

        $array = [
            [ "recipient_id"=>1,
              "dest_addr"=> $user->phone_number              ]
    ];




    $sms = Helper::sendSms($message,$array);

        return response()->json($user, 200);

    //




        $token = $user ->createToken('myapptoken')->plainTextToken;


        $response = [
            'user'=>$user,
            'token'=>$token
        ];

        return response($response, 201);


    }


    public function login(Request $request){



        $user = User::where('email',$request->email)->first();




        if($user && Hash::check($request->password, $user->password)){
            //if($user->status == 1){

                  //  $token = $user->createToken('Vikoba')->plainTextToken;
                  $otp = rand(0000,9999);
                    if($otp<10){
                        $otp = '000'.$otp;
                    }else if($otp<100){
                        $otp = '00'.$otp;
                    }else if($otp<1000){
                        $otp ='0'.$otp;
                    }else{
                        $otp = $otp;
                    }

                    //$otp = "7846";

                    Otp::create([
                        'email'=>$user->email,
                        'otp'=>Hash::make($otp),
                    ]);
                    $message = $otp.' is verification code for http://agrolives.co.tz';
                    $recept = [[
                        "recipient_id"=> 1,
                        "dest_addr"=>$user->phone_number
                    ]];

                  $data=   Helper::sendSms($message,$recept);
                  Log::info($data);
                  Log::info($recept);

                 // $token = $user ->createToken('myapptoken')->plainTextToken;


                 // $response = [
                  //    'user'=>$user,
                 //     'token'=>$token
                 // ];

                //  return response($response, 201);

           return response()->json(['user'=>$user,]);
        //}else{
           // return response()->json(['error'=>"user disable contact admin"], 409);
       // }
        }else{
            return response()->json(['error'=>'Invalid username and password combination'],401);
        }


    }

    public function otp(Request $request ){
        $user = User::find($request->id);
        $otp = Otp::where('email',$user->email)->whereBetween('created_at', [now()->subMinutes(60), now()])->orderBy('created_at','DESC')->first();
        if($otp){
        if(Hash::check($request->otp,$otp->otp)){

           Otp::where('email',$user->email)->delete();

                  $token = $user->createToken('Dirm')->plainTextToken;

                return response()->json(['user'=>$user,'token'=>$token],200);
        }
    }


    }

    public function logout(Request $request){
        Auth::user()->tokens()->delete();

        return response()->json(['message'=>'logout successfull']);
    }


    public function forgotPassword(Request $request){
        $login = strtolower($request->email);
        $phone =  '255'.ltrim($login, $login[0]);

        $user = User::where('email',$login)->orWhere('email',$login)->orWhere('phone_number',$phone)->first();
        if($user){
            $password = rand(111111,999999);
            $user->update([
                'password'=>Hash::make($password),
            ]);

            $array = [
                [ "recipient_id"=>1,
                  "dest_addr"=> $user->phone_number
                  ]
        ];
        $message = "Habari umefanikiwa kubadilisha namba yako ya siri namba yako mpya ya siri ni ".$password." kwenye agrolives #changamkiafursa";

        $sms = Helper::sendSms($message,$array);
        return response()->json(['success'=>'Umefanikiwa kubadilisha namba yako ya siri'], 200);

        }

        return response()->json(['error'=>'account not found'], 500);
    }

    public function passwordReset(Request $request){
        Log::debug($request);
        $user = User::find($request->id);
        if($user){
            if(Hash::check($request->old,$user->password)){
                return response()->json(['message'=>'old password is invalid'],422);
            }
            $validate = $request->validate([
                'password'=>'required|min:6|confirmed'
            ]);
            $user->update([
                'password'=>Hash::make($request->password),
            ]);
            return response()->json('password reset', 200);
        }else{
            return response()->json(['message'=>'Invalid user'],422);
        }
        return response()->json(['message'=>'Invalid user'],422);
    }



}
