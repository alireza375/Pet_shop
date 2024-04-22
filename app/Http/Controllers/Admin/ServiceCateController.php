<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Http\Controllers\Controller;
use App\Http\Services\Admin\ServiceService;
use App\Http\Requests\Admin\ServiceCateRequest;
use App\Http\Services\Admin\ServiceCateService;
use App\Http\Resources\Pagination\BasePaginationResource;

class ServiceCateController extends Controller
{
    //
    private $Category;

    public function __construct(ServiceCateService $Category)
    {
        $this->Category = $Category;
    }


    public function CateList(Request $request){
        $per_page = $request->per_page ?? PERPAGE_PAGINATION;
        $data = ServiceCategory::select('id as _id', 'name', 'created_at as createdAt', 'updated_at as updatedAt')->paginate($per_page);
        return successResponse(__('Service Category fetched successfully.'), new BasePaginationResource($data));
    }

    public function addOrUpdate(ServiceCateRequest $request){
        if($request->_id){
            return $this->Category->update($request);
        }else{
            return $this->Category->store($request);
        }
    }

    public function delete(Request $request){
        try {
            $cate = ServiceCategory::find($request->_id);
            if (!$cate) {
                return errorResponse(__('Service Category not found.'));
            }
            $cate->delete();
            return successResponse(__('Service Category deleted successfully.'));
        } catch (\Exception $e) {
            return errorResponse($e->getMessage());
        }
    }
}
