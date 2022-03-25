<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegistered;
use App\Verify\Service;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{


    /**
     * Verification service
     *
     * @var Service
     */
    protected $verify;

    /**
     * Create a new controller instance.
     *
     * @param Service $verify
     */
    public function __construct(Service $verify)
    {
        Log::debug("construction");
        $this->verify = $verify;
        $this->middleware('guest');
    }

    public function UserById(Request $request)
    {
        Log::debug("Specific User Request");
        $data = $request->validate([
            'id' => 'required',
        ]);

        Log::debug("UserById - Validated");

        return response()->json(
            User::first($request->id),
            203
        );
    }
    /**
     * Display Home page.
     *
     * @return Response
     */
    public function register(Request $request)
    {
        Log::debug("Register Process Started");
        $data = $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email|min:4|unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
            'firstname' => 'required',
            'lastname' => 'min:2',
            'nickname' => 'min:2',
            'mobile1' => 'min:10',
            'mobile2' => 'min:10',
            'mobile3' => 'min:10',
        ]);
        Log::debug("Register Validated");



        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'nickname' => $request->nickname,
            'mobile1' => $request->mobile1,
            'mobile2' => $request->mobile2,
            'mobile3' => $request->mobile3,
            'password' => Hash::make($request->password),
            'password_confirmation' => Hash::make($request->password_confirmation),
        ]);
        Log::debug("User Register Completed");
        // $token = $user->createToken($request->device_name)->plainTextToken;

        // $verification = $this->verify->startVerification($request->mobile1, $request->post('channel', 'sms'));
        // if (!$verification->isValid()) {
        //     Log::debug("Not verified");
        //     $user->delete();

        //     $errors = new MessageBag();
        //     foreach ($verification->getErrors() as $error) {
        //         $errors->add('verification', $error);
        //     }
        //     Log::debug($errors);
        //     return response()->json($errors, 444);
        // }

        // $messages = new MessageBag();
        // $messages->add('verification', "Code sent to {$request->user()->mobile1}");


        Mail::to($request->email)->send(new UserRegistered($user));
        // return response()->json([
        //     'token' => $token,
        //     'user' => $user->only('id', 'name', 'username', 'email', 'avatar')
        // ], 204);
        return response()->json(
            'Registerd',
            202
        );
    }
}
