<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandRequest;
use App\Http\Services\Admin\BrandService;
use App\Http\Resources\Pagination\BasePaginationResource;

class BrandController extends Controller
{
    //
    private $Brand;

    public function __construct(BrandService $Brand)
    {
        $this->Brand = $Brand;
    }


    public function BrandList(Request $request){
        $per_page = $request->per_page ?? PERPAGE_PAGINATION;
        $data = Brand::select('id as _id', 'name', 'created_at as createdAt', 'updated_at as updatedAt')->paginate($per_page);
        return successResponse(__('Brand fetched successfully.'), new BasePaginationResource($data));
    }

    public function addOrUpdate(BrandRequest $request){
        if($request->_id){
            return $this->Brand->update($request);
        }else{
            return $this->Brand->store($request);
        }
    }

    public function delete(Request $request){
        try {
            $cate = Brand::find($request->_id);
            if (!$cate) {
                return errorResponse(__('Brand not found.'));
            }
            $cate->delete();
            return successResponse(__('Brand deleted successfully.'));
        } catch (\Exception $e) {
            return errorResponse($e->getMessage());
        }
    }
}
