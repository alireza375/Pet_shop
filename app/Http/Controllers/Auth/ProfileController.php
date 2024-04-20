<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ProfileRequest;
use App\Http\Services\Auth\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //
    private $ProfileService;

    public function __construct(ProfileService $ProfileService)
    {
        $this->ProfileService = $ProfileService;
    }

    public function GetProfile(){
        return $this->ProfileService->GetProfile();
    }

    public function UpdateProfile(ProfileRequest $request){
        return $this->ProfileService->UpdateProfile($request);
    }


}
