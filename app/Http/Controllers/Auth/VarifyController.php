<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VarifyRequest;
use App\Http\Services\Auth\VarifyService;
use Illuminate\Http\Request;

class VarifyController extends Controller
{
    //
    private $VarifyService;

    public function __construct(VarifyService $VarifyService){
        $this->VarifyService = $VarifyService;
    }
    public function SentOtp(VarifyRequest $request){
        return $this->VarifyService->SentOtp($request);

    }


    public function VerifyOtp(Request $request){
        return $this->VarifyService->VerifyOtp($request);
    }

}
