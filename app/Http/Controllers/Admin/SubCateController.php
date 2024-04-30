<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubCateRequest;
use App\Http\Services\Admin\SubCateService;
use App\Models\Sub_Category;
use Illuminate\Http\Request;

class SubCateController extends Controller
{
    //
    private $subCateService;

    public function __construct(SubCateService $subCateService)
    {
        $this->subCateService = $subCateService;
    }

    public function index(Request $request){
        return $this->subCateService->SubCateList($request);
    }


    public function AddOrUpdate(SubCateRequest $request){
        return $this->subCateService->store($request);
    }


    public function delete(Request $request){
        try {
            $subCate = Sub_Category::find($request->_id);
            if (!$subCate) {
                return errorResponse(__('Sub Category not found.'));
            }
            $subCate->delete();
            return successResponse(__('Sub Category deleted successfully.'));
        } catch (\Exception $e) {
            return errorResponse($e->getMessage());
        }
    }
}
