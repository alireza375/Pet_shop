<?php

namespace App\Http\Controllers\Admin;

use App\Models\Newsletter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsletterRequest;
use App\Http\Services\Admin\NewsletterService;
use App\Http\Resources\Pagination\BasePaginationResource;

class NewsletterController extends Controller
{
    //
    private $NewsletterService;

    public function __construct(NewsletterService $NewsletterService)
    {
        $this->NewsletterService = $NewsletterService;
    }

    public function ListNews(Request $request){
        // $sort_by = $request->sort_by ?? 'id';
        // $dir = $request->dir ?? 'desc';
        $per_page = $request->per_page ?? PERPAGE_PAGINATION;
        $data = Newsletter::select('id as _id', 'email','created_at as createdAt', 'updated_at as updatedAt')->paginate($per_page);
        return successResponse(__('Newsletters fetched successfully.'), new BasePaginationResource($data));

    }

    public function newsletter(NewsletterRequest $request){
        return $this->NewsletterService->newsletter($request);
    }

    public function DelNewsletter(Request $request){
        try {
            $newsLetter = Newsletter::find($request->_id);
            if (!$newsLetter) {
                return errorResponse(__('Newsletter not found.'));
            }
            $newsLetter->delete();
            return successResponse(__('Newsletter deleted successfully.'));
        } catch (\Exception $e) {
            return errorResponse($e->getMessage());
        }
    }
}
