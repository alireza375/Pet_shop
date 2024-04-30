<?php

namespace App\Http\Services\Admin;

use App\Models\ServiceCategory;

class ServiceCateService
{
    public function makeData($request){
        $data = [
            'name' => $request->name,

        ];
        return $data;
    }


    public function store($request){
        try {
            // Create a new Category
            $cate = ServiceCategory::create($this->makeData($request));

            return successResponse(__('Service Category created successfully.'), $cate);
        } catch (\Exception $e) {
            return errorResponse($e->getMessage());
        }

    }

    public function update($request){
        $category = ServiceCategory::where(['id' => $request->_id])->first();
        if (!empty($category)) {
            $data = $this->makeData($request);
            try {
                $category->update($data);
                return successResponse(__('Category updated successfully'), $data);
            } catch (\Exception $e) {
                return errorResponse($e -> getMessage());
            }
        }
    }

}
