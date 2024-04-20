<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\AuthRequest;
use App\Http\Services\Auth\AuthService;

class AuthController extends Controller
{
    //
    private $AuthService;

    public function __construct(AuthService $AuthService){
        $this->AuthService = $AuthService;
    }

    public function registration(AuthRequest $request){
        return $this->AuthService->registration($request);
    }

    public function login(Request $request){

       $user = User::where('email', $request->email)->orWhere('username', $request->username)->first();

       if (empty($user)) {
           return errorResponse(__('User not found'));
       }
       if (!Hash::check($request->password, $user->password)) {
           return errorResponse(__('Password not matched'));
        }
        $token = $user->createToken($user->uuid . 'user')->accessToken;

        return successResponse(__('Login successfull'), ['token' => $token,'role' => $user->role == USER ? 'user' : ($user->role == TRAINER ? 'agent' : 'admin')]);
    }

    public function ResetPassword(Request $request){
        return $this->AuthService->ResetPassword($request);

    }

    public function UpdatePassword(Request $request){
        return $this->AuthService->UpdatePassword($request);
    }

}
