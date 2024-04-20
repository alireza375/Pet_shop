<?php

namespace App\Http\Services\Auth;

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{

    public function registration($request){

        $role = USER;
        if($request->role == "user" || $request->role == "trainer"){
            if($request->role == "user"){
                $role = USER;
            }else{
                $role = TRAINER;
            }
        }else{
            return errorResponse("Invalid Role");
        }

        $checkUser = User::where(['email' => $request->email])->exists();
        if($checkUser){
            return errorResponse("Email Already exists");
        }

        $checkOtp = otpVerify($request->email, $request->otp, "registration");
        if($checkOtp['status'] == false){
            return errorResponse($checkOtp['message']);
        }

        $data = [
            'uuid' => Str::uuid(),
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $role,
            'status' => ACTIVE,
            'is_mail_verified' => ENABLE
        ];

        try {
            $user = User::create($data);
            $token = $user->createToken($user->uuid . 'user')->accessToken;
            return successResponse(__('Registration successfull'), [$user,'role' => $request->role]);
        }
        catch (\Exception $e) {
            return errorResponse($e->getMessage());
        }
    }


    public function ResetPassword($request){
        $decoded = JWT::decode($request->token, new Key(env('JWT_SECRET'), 'HS256'));
        $decoded_array = (array) $decoded;
         $decoded_array['email'];

        $user = User::where(['email' => $decoded_array['email']])->first();
        if (empty($user)) {
            return errorResponse(__('User not found'));
        }
        $user->password = Hash::make($request->password);
        $user->save();
        return successResponse(__('Password reset successfully'));

    }

    public function UpdatePassword($request){
        $user = Auth::guard('user')->user();
        $user = User::where(['email' => $user->email])->first();

        if(!Hash::check($request->old_password, $user->password)){
            return errorResponse('Old Password not matched');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return successResponse('Password Update Successfully');
    }


}
