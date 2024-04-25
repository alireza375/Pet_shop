<?php

namespace App\Http\Services\Admin;

use App\Models\User;
use App\Http\Resources\Admin\TrainerResource;

class TrainerService
{
    public function makeData($request){
        $data = [
         'user_name' => $request->user_name,
         'email' => $request->email,
         'phone' => $request->phone,
         'birthday' => $request->birthday,
         'gender' => $request->gender,
         'role' => $request->role,
         'image' => $request->hasFile('image') ? fileUpload($request->file('image'), public_path("Auth") ) :  null,
         (public_path("About_logos"))
     ];
     // PATH_GALLERIES
     return $data;
    }


    public function store($request){
        $trainer = User::where(['id' => $request->_id])->first();
        if (!empty($trainer)) {
            $data = $this->makeData($request);
            try {
                $trainer->update($data);
                return successResponse(__('Trainer Created successfully'),[$data, 'role' => $trainer->role == 2 ? 'trainer':'user']);
            } catch (\Exception $e) {
                return errorResponse($e -> getMessage());
            }
        }
    }
}
