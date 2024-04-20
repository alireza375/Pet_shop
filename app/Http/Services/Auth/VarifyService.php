<?php

namespace App\Http\Services\Auth;

use Exception;
use Carbon\Carbon;
use App\Models\Otp;
use App\Models\User;
use Firebase\JWT\JWT;

class VarifyService
{

    public function SentOtp($request){
        $otp = randomNumber(4);
        do {
            $otp = randomNumber(4);
            $exists_otp = Otp::where(['otp' => $otp])->exists();
        }while($exists_otp);

        $token_data = [
            'otp' => $otp,
            'email' => $request->email,
            'type' => $request->type,
            // 'expired_at' => Carbon::now()->addMinutes(3),
            'expired_at' => Carbon::now()->addMinutes(3),
        ];

        try{
            Otp::updateOrcreate(['email' => $request->email], $token_data);

            $data = [
                'email' => $request->email,
                'otp' => $otp,
                // 'expired_at' => $token_data['expired_at'],
            ];
            return successResponse("OTP Sent SuccessFully", $data);
        }catch(Exception $e){
            return errorResponse($e->getMessage());
        }

        // return "OTP sent";
    }

    // public function VerifyOtp($request){
    //     $otp = Otp::where(['otp' => $request->otp, 'email' => $request->email])->first();
    //     if (empty($otp)) {
    //         return errorResponse(__('not_matched', ['key' => __('OTP')]));
    //     }
    //     if (Carbon::now() > Carbon::parse($otp->expired_at)) {
    //         return errorResponse(__('OTP has been expired'));
    //     }
    //     $otp->delete();
    //     $user = User::where(['email' => $request->email])->first();

    //     $decoded_array = [
    //         'email' => $request->email,
    //     ];

    //     $encoded = JWT::encode($decoded_array, env('JWT_SECRET'), 'HS256');

    //     return successResponse(__('OTP verified successfully'), ['token' => $encoded]);

    // }


    public function VerifyOtp($request){
        $otp = Otp::where(['otp' => $request->otp, 'email' => $request->email])->first();
        if (empty($otp)) {
            return errorResponse(__('OTP not matched'));
        }
        if (Carbon::now() > Carbon::parse($otp->expired_at)) {
            return errorResponse(__('OTP has been expired'));
        }
        $otp->delete();
        $user = User::where(['email' => $request->email])->first();

        $decoded_array = [
            'email' => $request->email,
        ];

        $encoded = JWT::encode($decoded_array, env('JWT_SECRET'), 'HS256');

        return successResponse(__('OTP verified successfully'), ['token' => $encoded]);

    }



}
