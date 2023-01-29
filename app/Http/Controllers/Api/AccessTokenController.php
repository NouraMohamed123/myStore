<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AccessTokenController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'abilities' => 'nullable|array',
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            $device_name = $request->post('device_name', $request->userAgent());
            $token = $user->createToken(
                $device_name,
                $request->post('abilities')
            );

            return response()->json(
                [
                    'token' => $token->plainTextToken,
                    'user' => $user,
                ],
                201
            );
        }
    }

    public function destory($token = null)
    {
        $user = Auth::guard('sanctum')->user();

        if (null == $token) {
            $user->currentAccessToken()->delete();
            return;
        }
        // $personalAccessToken = PersonalAccessToken::findToken($token);
        //     if ($user->id == $personalAccessToken->tokenable_id) {
        //   $personalAccessToken->delete();

        $user
            ->tokens()
            ->where('token', $token)
            ->delete();

        // }
    }
}