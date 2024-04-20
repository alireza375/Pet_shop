<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PageRequest;
use App\Http\Services\Admin\PageService;
use App\Http\Resources\Admin\PageResource;

class PageController extends Controller
{
    //
    private $PageService;

    public function __construct(PageService $pageService)
    {
        $this->PageService = $pageService;
    }

    public function index(Request $request){
        $perPage = $request->per_page ?? PERPAGE_PAGINATION;
        // $sortBy  = !empty($request->sort_by) ? $request->sort_by : 'id';
        // $dir     = !empty($request->dir) ? $request->dir : 'asc';

        $page = Page::select('id', 'title', 'slug', 'content', 'content_type', 'enable')->paginate($perPage);
        $page->when(!empty(request('search')), function ($q) use ($request) {
            return $q->where('title', '%' . $request->search . '%');
        });

        // $page = $query->orderBy($sortBy, $dir)->get();
        return successResponse("Page list", PageResource::collection($page));

    }

    public function getPage(Request $request)
    {
        $slug = $request->input('slug');
        $page = Page::where('slug', $slug)->first();

        if ($page) {
            return successResponse("Page fetched successfully", new PageResource($page));
        } else {
            return errorResponse("'{$slug}' doesn't exist", 404);
        }
    }


    public function updateOrcreate(PageRequest $request){
        if (!empty($request->_id)) {
            return $this->PageService->update($request);
        } else {
            return $this->PageService->store($request);
        }
    }


    public function deletePage(Request $request)
    {
        $slug = $request->input('slug');
        $page = Page::where('slug', $slug)->first();
        try {
            $page = Page::where('slug', $slug)->first();
            if (!$page) {
                return errorResponse(__('Page not found.'));
            }
            $page->delete();
            return successResponse(__('Page deleted successfully.'));
        } catch (Exception $e) {
            return errorResponse($e->getMessage());
        }
    }
}
