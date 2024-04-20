<?php

namespace App\Http\Services\Admin;

use App\Models\Faq;
use Exception;

class FaqService
{

    public function makeData($request){
        $data = [
            'title' => $request->title,
            'description' => $request->description,
        ];
        return $data;
    }


    public function store($request){
        try {
            // Create a new Faq
            $faq = Faq::create($request->all());
            // $faq->save();

            return successResponse(__('Faq created successfully.'), $faq);
        } catch (\Exception $e) {
            return errorResponse($e->getMessage());
        }

    }

    public function update($request){
        $faq = Faq::where(['id' => $request->_id])->first();
        if (!empty($faq)) {
            $data = $this->makeData($request);
            try {
                $faq->update($data);
                return successResponse('Faq updated successfully');
            } catch (Exception $e) {
                return errorResponse($e -> getMessage());
            }
        }
    }

}
