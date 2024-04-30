<?php

namespace App\Http\Services\Admin;

use Exception;
use App\Models\Sub_Category;
use App\Models\ServiceCategory;
use App\Http\Resources\Admin\SubCateResource;

class SubCateService
{
    public function makeData($request){
        $data = [
            'service_categories_id' => $request->service_categories_id,
            'name' => $request->name,
        ];
        return $data;
    }


    public function SubCateList($request) {
        $id = $request->input('service_categories_id');
        $subCate = Sub_Category::all();

        if ($subCate->isNotEmpty()) {
            return successResponse("Sub Category fetched successfully", SubCateResource::collection($subCate));
        } else {
            return errorResponse(__('Sub Category Id Not found'));
        }
    }


    public function store($request){
        try{
            $subCate = Sub_Category::create($this->makeData($request));

            return successResponse( __('Sub Category Created Successfully'), $subCate);
        }catch(Exception $e){
            return $e->getMessage();
        }

    }

    

}
