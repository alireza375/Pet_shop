<?php

namespace App\Http\Services\Admin;

use Exception;
use App\Models\Review;
use Illuminate\Http\Request;


class ReviewService
{

    public function makeData($request)
    {
        $data = [
            'user_id' => $request->get('user'),
            'product_id' => $request->get('product'),
            'rating' => $request->get('rating'),
            'review' => $request->get('review'),
        ];
        return $data;
    }


    //Review store
    public function store($request){
        try {
            $data = $this->makeData($request);
            $product = Review::create($data);
            return successResponse(__('Review has been Added successfully'), $product);
        } catch (\Exception $e) {
            return errorResponse($e->getMessage());
        }
    }

    public function update($request){
        $review = Review::where(['id' => $request->_id])->first();
        if (!empty($review)) {
            $data = $this->makeData($request);
            try {
                $review->update($data);
                return successResponse(__('Review updated successfully'), $data);
            } catch (\Exception $e) {
                return errorResponse($e -> getMessage());
            }
        }
    }


    public function delete($request)
    {
        try {
            $Review = Review::find($request->_id, );
            if (!$Review) {
                return errorResponse(__('Review not found.'));
            }
            $Review->delete();
            return successResponse(__('Review has been deleted successfully'));
        } catch (\Exception $e) {
            return errorResponse($e->getMessage());
        }
    }


}
