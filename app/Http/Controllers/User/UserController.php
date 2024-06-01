<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\LogoutRequest;
use App\Models\User;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Sanctum\NewAccessToken;

class UserController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $attributes = $request->validated();

        //$attempt = Auth::guard('web')->attempt($attributes, $request->exists('remember'));
        $attempt = Auth::attempt($attributes, $request->exists('remember'));

        if (! $attempt){
            return response()->json([
                'success' => false,
                'message' => 'wrong login or/and password',
            ], 401);
        }

        //$user = Auth::guard('web')->user();
        $user = Auth::user();

        /** @var User $user */
        $token = $user->createToken(Str::random(11));

        return response()->json([
            'success' => $attempt,
            'token' => $token->plainTextToken,
        ]);
    }

    public function logout(LogoutRequest $request)
    {
        //return $request->validated();
        //Auth::loginUsingId(14);

        return response()->json([
            'tokens' => $request->user()->tokens(),
            //'currentAccessToken' => $request->user()->currentAccessToken(),
            'user' => $request->user(),
        ]);

        //$user->currentAccessToken()->delete();

        //$user->tokens()->delete();

        //$user->tokens()->where('id', $tokenId)->delete();
    }

    public function chich(Request $request)
    {
        //Auth::loginUsingId(13);

        /** @var User $user */
        $user = $request->user();
        //$user = Auth('sanctum')->user();

        return response()->json([
//            '$bearerToken' => request()->bearerToken(),
//            'currentAccessToken' => $user->currentAccessToken(),
//            'tokens' => $user->tokens()->first(),
//            'count' => $user->tokens()->count(),
            'user' => $user,
        ]);
    }
}
