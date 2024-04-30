<?php

namespace App\Http\Services\Admin;

use App\Models\Brand;

class BrandService
{
    public function makeData($request){
        $data = [
            'name' => $request->name,
        ];
        return $data;
    }


    public function store($request){
        try {
            // Create a new brand
            $cate = Brand::create($request->all());
            // $brand->save();

            return successResponse(__('Brand created successfully.'), $cate);
        } catch (\Exception $e) {
            return errorResponse($e->getMessage());
        }
    }

    public function update($request){
        $category = Brand::where(['id' => $request->_id])->first();
        if (!empty($category)) {
            $data = $this->makeData($request);
            try {
                $category->update($data);
                return successResponse(__('Brand updated successfully'), $data);
            } catch (\Exception $e) {
                return errorResponse($e -> getMessage());
            }
        }
    }

}
