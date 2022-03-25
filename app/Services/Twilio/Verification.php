<?php


namespace App\Services\Twilio;


use App\Verify\Result;
use App\Verify\Service;
use Illuminate\Support\Facades\Log;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;


class Verification implements Service
{

    /**
     * @var Client
     */
    private $client;


    /**
     * @var string
     */
    private $verification_sid;


    /**
     * Verification constructor.
     * @param $client
     * @param string|null $verification_sid
     * @throws \Twilio\Exceptions\ConfigurationException
     */
    public function __construct($client = null, string $verification_sid = null)
    {
        Log::debug("construction verificaion");
        $sid = getenv('TWILIO_ACCOUNT_SID');
        $token = getenv('TWILIO_AUTH_TOKEN');

        if ($client === null) {
            $sid = 'ACc68bbcd55559112e1abd2fd5d140940e';
            $token = '88e9a7dbd8f5ac17bf3e37ca78a1a5ab';
            Log::debug($sid);
            $client = new Client($sid, $token);
        }
        $verificationCode = 'VAf14f7873049f1dba6173835d0890c808';
        $this->client = $client;
        $this->verification_sid = $verification_sid ?: $verificationCode;
    }


    /**
     * Start a phone verification process using Twilio Verify V2 API
     *
     * @param $phone_number
     * @param $channel
     * @return Result
     */
    public function startVerification($phone_number, $channel)
    {
        try {
            $verification = $this->client->verify->v2->services($this->verification_sid)
                ->verifications
                ->create($phone_number, $channel);
            return new Result($verification->sid);
        } catch (TwilioException $exception) {
            return new Result(["Verification failed to start: {$exception->getMessage()}"]);
        }
    }

    /**
     * Check verification code using Twilio Verify V2 API
     *
     * @param $phone_number
     * @param $code
     * @return Result
     */
    public function checkVerification($phone_number, $code)
    {
        try {
            $verification_check = $this->client->verify->v2->services($this->verification_sid)
                ->verificationChecks
                ->create($code, ['to' => $phone_number]);
            if ($verification_check->status === 'approved') {
                return new Result($verification_check->sid);
            }
            return new Result(['Verification check failed: Invalid code.']);
        } catch (TwilioException $exception) {
            return new Result(["Verification check failed: {$exception->getMessage()}"]);
        }
    }
}
