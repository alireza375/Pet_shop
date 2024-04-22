<?php

namespace App\Http\Services\Admin;

use App\Models\User;
use GuzzleHttp\Psr7\Request;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Resources\Admin\UserResource;
use App\Http\Resources\Admin\UserDetailsResource;
use App\Http\Resources\Pagination\BasePaginationResource;
use App\Models\UserDetails;

class UserService
{
    public function makeData($request){
        $data = [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'image' => $request->get('image'),
            'role' => $request->get('role'),
            'address' => $request->get('address'),
            'facebook' => $request->get('facebook'),
            'twitter' => $request->get('twitter'),
            'linkedin' => $request->get('linkedin'),
            'about' => $request->get('about'),
            'position' => $request->get('position')

        ];
        return $data;
    }

    public function index($request){
        $per_page = $request->per_page ?? PERPAGE_PAGINATION;
        $data = User::where(['role' => USER])->paginate($per_page);
        $data = UserResource::collection($data);
        return successResponse(__('Users fetched successfully.'), new BasePaginationResource($data));

    }


    public function show($request)
    {
       if($request->_id){
            $data = User::find($request->_id);
            return successResponse(__('User fetched successfully.'),    new UserDetailsResource($data));
        }
    }


    public function store(UserRequest $request){
        try {
            $details = UserDetails::create($request->all());
            return successResponse(__('User Details created successfully.'), $details);
        } catch (\Exception $e) {
            return errorResponse($e->getMessage());
        }
    }



}
