<?php

use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\UserCallingDetailsController;
use App\Http\Controllers\UserController;
use App\Models\Call;
use App\Models\User;
use App\Models\UserCallingDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/calls', function () {
    return UserCallingDetails::with('user:name,id,username,avatar')->latest()->paginate(20);
});

Route::get('/call/{call}', function (UserCallingDetails $usercallingdetails) {
    return $usercallingdetails->load('user:name,id,username,avatar');
});
//UserCallingDetailsController

Route::get(
    '/Calls/DetailsByUserId/{userid}',
    function (UserCallingDetails $usercallingdetails) {
        Log::debug("Into -- DetailsByDay - DetailsByUserId");
        return response()->json(
            UserCallingDetails::all(),
            203
        );
    }
);
Route::get(
    '/Calls/DetailsByDay/{userid}',
    function (UserCallingDetails $usercallingdetails) {
        Log::debug("Into -- DetailsByDay");
        $yesterday = Carbon::yesterday();
        $today = Carbon::today();
        $yesterday =  UserCallingDetails::whereBetween('created_at', [now()->subMinutes(1440), now()])->get();;

        return response()->json(
            $yesterday,
            203
        );
    }
);

Route::middleware('auth:sanctum')->post(
    '/calls',
    function (Request $request) {
        $request->validate([
            'user_id' => 'required',
            'incoming_message' => 'required',
            'calling_mobile' => 'required',
            'alert_sent' => 'required',
            'trained' => 'required',
            'kb_id' => 'required'
        ]);
        return UserCallingDetails::create(
            [
                'user_id' => $request->user_id,
                'incoming_message' => $request->incoming_message,
                'calling_mobile' => $request->calling_mobile,
                'calling_mobile_exist' => $request->calling_mobile_exist,
                'contact_list_name' => $request->contact_list_name,
                'case_Type' => $request->case_Type,
                'alert_sent' => $request->alert_sent,
                'trained' => $request->trained,
                'kb_id' => $request->kb_id
            ],

        );
    }
);
//User Registration
Route::post(
    '/register',
    [UserController::class, 'register']
);
Route::middleware('auth:sanctum')->post(
    '/UserById',
    [UserController::class, 'UserById']
);




Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);
    // sleep(5);
    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    $token = $user->createToken($request->device_name)->plainTextToken;
    return response()->json([
        'token' => $token,
        'user' => $user->only('id', 'name', 'username', 'email', 'avatar')
    ], 201);
});


Route::middleware('auth:sanctum')->post(
    '/logout',
    function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json('Logged Out', 202);
    }
);



// Password reset link request routes...
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->middleware('guest');;

// Password reset routes...

Route::get('reset-password/{token}', [ResetPasswordController::class, 'create'])
    ->name('password.reset')->middleware('guest');

Route::post('reset-password', [ResetPasswordController::class, 'store'])
    ->name('password.update')->middleware('guest');



Route::get('/emails', [EmailController::class, 'create']);
Route::post('/emails', [EmailController::class, 'sendEmail']);
