<?php

namespace App\Http\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Auth\ProfileResource;
use Exception;

class ProfileService
{
    public function makeData($request){
       $data = [
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'birthday' => $request->birthday,
        'gender' => $request->gender,
        // 'image' => $request->gender,
        'image' => $request->hasFile('image') ? fileUpload($request->file('image'), public_path("Auth") ) :  null,
        (public_path("About_logos"))
    ];
    // PATH_GALLERIES
    }

    public function GetProfile(){
        return successResponse(('Profile Fatched Successfully'),
        ProfileResource::make(Auth::guard('checkUser')->user())
        );
    }

    public function UpdateProfile($request){
        $user = Auth::guard('checkUser')->user();
        $user = User::where(['email' => $user->email])->first();

        $data = $request->all();
        try{
            $user->update($data);
            return successResponse(
                ( 'Profile Update Successfully'),
                ProfileResource::make($user)
            );
        }catch(Exception $e){
            return errorResponse($e -> getMessage());
        }


    }


}
