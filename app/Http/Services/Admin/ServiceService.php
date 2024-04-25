<?php

namespace App\Http\Services\Admin;

use App\Models\Service;
use GuzzleHttp\Psr7\Request;
use App\Http\Resources\Pagination\BasePaginationResource;

class ServiceService
{
    public function makeData($request){

        $data = [
            'title' => $request->title,
            'short_description' => $request->short_description,
            'image' => $request->hasFile('image') ? fileUploadAWS($request->file('image'), 'public') :  null,
            'price' => $request->price,
            'category_id' => $request->category,
            'address' => $request->address,
        ];
        return $data;
    }

    public function index($request){
        $per_page = $request->per_page ?? PERPAGE_PAGINATION;
        $data = Service::select('id as _id', 'title', 'short_description', 'price', 'image','category_id as category', 'address', 'created_at as createdAt', 'updated_at as updatedAt')->paginate($per_page);
        return successResponse(__('Service fetched successfully.'), new BasePaginationResource($data));
    }

    

    public function Store($request){
        try {
            // Create a new Service
            $service = Service::create($request->all());

            return successResponse(__('Service created successfully.'), $service);
        } catch (\Exception $e) {
            return errorResponse($e->getMessage());
        }
    }


    public function Update($request){
        $service = Service::where(['id' => $request->_id])->first();
        if (!empty($service)) {
            $data = $this->makeData($request);
            try {
                $service->update($data);
                return successResponse(__('Service updated successfully'), $data);
            } catch (\Exception $e) {
                return errorResponse($e -> getMessage());
            }
        }
    }



}
