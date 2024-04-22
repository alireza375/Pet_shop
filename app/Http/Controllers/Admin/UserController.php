<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Admin\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    private $UserService;

    public function __construct(UserService $UserService){
        $this -> UserService = $UserService;
    }

    public function index(Request $request){
        return $this->UserService->index( $request);
    }

    public function show(Request $request){
        return $this->UserService->show( $request);
    }

    public function addOrUpdate(Request $request){
        if($request->_id){
            // return $this->UserService->update($request);
        }else{
            return $this->UserService->store($request);
        }
    }


}
