<?php

namespace App\Http\Controllers;

use App\Models\UserCallingDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserCallingDetailsController extends Controller
{
    public function index()
    {
        return UserCallingDetails::with('user:name,id,username,avatar')->latest()->paginate(10);
    }

    public function DetailsByUserId(Request $request)
    {
        Log::debug("Specific User Request");
        // $data = $request->validate([
        //     'id' => 'required',
        // ]);

        Log::debug("UserById - Validated");

        return response()->json(
            UserCallingDetails::all(),
            203
        );
    }

    //
}
