<?php
namespace App\Helper;
use App\Models\Sms;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class Helper{


    public static function sendSms($message,$recep){
        $response = Http::withBasicAuth(
                env('SMS_API_KEY'),env('SMS_SECRETE_KEY'),
            )->post(env('SMS_URL'),

                [
                    "source_addr"=>env('SMS_HEADER'),
                    "encoding"=> 0,
                    "schedule_time"=>"",
                    "message"=>$message,
                    "recipients"=>$recep
                ]
            ) ;




                $sms  = Sms::create([
                    'sms'=>$message
                ]);





                return $response;
    }


    public static function post($uri, $data, $headers)
    {
        try {
            $client = new Client();
            $URI = $uri;
            $params['headers'] = $headers;
            $params['json'] = $data;
            $response = $client->post($URI, $params);
            $response = $response->getBody()->getContents();
            Log::debug($response);
            $res = json_decode($response);
            return $res->body;
        } catch (\Exception $exception) {
            return null;
        }
    }

    public static function push($phone,$amount,$transactionId){

        $username = env('PAYMENT_USERNAME');
        $password = env('PAYMENT_PASSWORD');
        $timestap = Carbon::now()->format("YmdHis");
        $apiPassword = base64_encode(hash('sha256', $username.$password.$timestap, true));

        $header = [
            'username' => $username,
            'password' => $apiPassword,
            'timestamp' => $timestap,
        ];

        $request = [
                "command"=> "UssdPush",
                "transactionNumber"=>$transactionId,
                "msisdn"=> $phone,
                "amount"=> 200//$amount

        ];


        $data = [
            'header' => $header,
            'body' => [
                'request' => $request
            ]
        ];
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];
        $data = Helper::post(env("PAYMENT_PUSH_URL"), $data, $headers);

        return response()->json($data, 200,$header);
    }


    public static function pushPayment($phone,$amount){




            $username = env('PAYMENT_USERNAME');
            $password = env('PAYMENT_PASSWORD');
            $timestap = Carbon::now()->format("YmdHis");
            $apiPassword = base64_encode(hash('sha256', $username.$password.$timestap, true));

            $header = [
                'username' => $username,
                'password' => $apiPassword,
                'timestamp' => $timestap,
            ];

            $request = [
                    "command"=> "UssdPush",
                    "transactionNumber"=>$timestap.Auth::user()->id,
                    "msisdn"=> $phone,
                    "amount"=> 500//$amount

            ];


            $data = [
                'header' => $header,
                'body' => [
                    'request' => $request
                ]
            ];
            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ];
            $response = Helper::post(env("PAYMENT_PUSH_URL"), $data, $headers);
            return response()->make($response, 200, $headers);




    }


    public static function passwordSms($recep,$password){

        $message = 'KARIBU Vicoba Poa.Umefanikiwa kujiunga kwenye mfumo wa vikundi , namba yako ya siri ni: '. $password. ' Bonyeza:https://drive.google.com/file/d/1LWLmryzoYVU4aWJg7hT0T2WZlfiZNCXO/view?usp=sharing kupakua app yetu. Asante kwa kuchagua Vicoba Poa';

        $response = Http::withBasicAuth(
            env('SMS_API_KEY'),env('SMS_SECRETE_KEY'),
        )->post(env('SMS_URL'),

            [
                "source_addr"=>env('SMS_HEADER'),
                "encoding"=> 0,
                "message"=>$message,
                "recipients"=>[
                    [
                        "recipient_id"=> 1,
                        "dest_addr"=>$recep
                    ],

                ],
            ]
        );



                $sms  = Sms::create([
                    'sms'=>$message
                ]);





                return $response;
    }
}

?>
