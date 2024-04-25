<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Services\Admin\ProductService;
use App\Http\Resources\Pagination\BasePaginationResource;

class ProductController extends Controller
{
    //
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }


    //service list show
    public function index(Request $request)
    {
        $per_page = $request->per_page ?? PERPAGE_PAGINATION;
        $data = Product::select(
            'id as _id', 'name', 'images', 'price', 'brand_id as brand','sku_code',
            'weight', 'short_description', 'description','created_at as createdAt',
            'updated_at as updatedAt')->paginate($per_page);

            return successResponse(__('Product fetched successfully.'), new BasePaginationResource($data));

        }


    //service details show
    public function getproduct(Request $request)
    {
        return $this->productService->getproduct($request);
    }

    //add service
    public function updateOrAddproduct(ProductRequest $request)
    {
       if($request->_id){
          return $this->productService->update($request);
        }else{
           return $this->productService->store($request);
        }
    }

    //delete
    public function delete($request)
    {
        try {
            $product = Product::find($request->_id);
            if (!$product) {
                return errorResponse(__('Product not found'));
            }
            $product->delete();
            return successResponse(__('Product has been deleted successfully'));
        } catch (\Exception $e) {
            return errorResponse($e->getMessage());
        }
    }

}
