<?php

namespace App\Http\Controllers\Admin;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReviewRequest;
use App\Http\Services\Admin\ReviewService;
use App\Http\Resources\Admin\ReviewResource;
use App\Http\Resources\Pagination\BasePaginationResource;

class ReviewController extends Controller
{
    //
    private $review;

    public function __construct(ReviewService $review)
    {
        $this->review = $review;
    }


    //service list show
    public function index(Request $request){
        try {
            $product_id = $request->input('product_id');

            $productReviews = Review::where('product_id', $product_id)->first();

            if(!$productReviews){
                return errorResponse(__('No reviews found for the specified product.'));
            }

            $per_page = $request->per_page ?? PERPAGE_PAGINATION;
            $reviews = Review::where('product_id', $product_id)
                            ->with(['product', 'user:id,name,email'])
                            ->paginate($per_page);

            $transformedData = ReviewResource::collection($reviews);
            $paginationResource = new BasePaginationResource($transformedData);

            return successResponse(__('Successfully fetched reviews'), $paginationResource);
        } catch(\Exception $e) {
            return errorResponse($e->getMessage());
        }
    }



    //add service
    public function addReviewUpdate(ReviewRequest $request)
    {
        if($request->_id){
            return $this->review->update($request);

        }else{
            return $this->review->store($request);

        }
    }


    //delete
    public function delete(Request $request)
    {
        return $this->review->delete($request);
    }
}
