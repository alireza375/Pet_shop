<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FaqRequest;
use App\Http\Services\Admin\FaqService;
use App\Http\Resources\Pagination\BasePaginationResource;

class FaqController extends Controller
{
    //
    private $FaqService;

    public function __construct(FaqService $FaqService)
    {
        $this->FaqService = $FaqService;
    }

    public function FaqList(Request $request){
        $per_page = $request->per_page ?? PERPAGE_PAGINATION;
        $data = Faq::select('id as _id', 'title', 'description', 'created_at as createdAt', 'updated_at as updatedAt')->paginate($per_page);
        return successResponse(__('faq fetched successfully.'), new BasePaginationResource($data));

    }

    public function Faq(FaqRequest $request){
        if($request->_id){
            return $this->FaqService->update($request);
        }else{
            return $this->FaqService->store($request);
        }
    }


    public function Delete(Request $request){
        try {
            $faq = Faq::find($request->_id);
            if (!$faq) {
                return errorResponse(__('Faq not found.'));
            }
            $faq->delete();
            return successResponse(__('Faq deleted successfully.'));
        } catch (\Exception $e) {
            return errorResponse($e->getMessage());
        }
    }
}
