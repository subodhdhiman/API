<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use GuzzleHttp\Client as GuzzleHttpClient;
use Twilio\Rest\Client;


class TwilioSMSController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        $receiverNumber = "RECEIVER_NUMBER";
        $message = "AI5 - Testing the SMS Services from Twilio";



        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_TOKEN");
        $twilio_number = getenv("TWILIO_FROM");

        $client = new Client($account_sid, $auth_token);
        $response = $client->messages->create($receiverNumber, [
            'from' => $twilio_number,
            'body' => $message
        ]);

        return $response;
    }
}
