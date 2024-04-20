<?php

namespace App\Http\Services\Admin;

use Exception;
use App\Models\Page;
use Illuminate\Support\Str;

class PageService
{

    public function makeData($request)
    {
        return [
            'title'        => $request->input('title'),
            'slug'         => $request->input('slug'),
            'content'      => $request->input('content'),
            'content_type' => $request->input('content_type'),
        ];
    }

    public function store($request){
        $slug = Str::slug($request->input('slug'));
        $existingPage = Page::where('slug', $slug)->exists();

        if ($existingPage) {
            return errorResponse("Page already exists.");
        }
        //making content json
        $content = json_encode($request->input('content'));
        $data = array_merge($this->makeData($request), ['slug' => $slug, 'content' => $content]);
        try {
            $page = Page::create($data);
            return successResponse( __("Page successfully created"), $data);
        } catch (Exception $e) {
            return errorResponse($e->getMessage());
        }
    }

    public function update($request){
        $page = Page::where(['id' => $request->_id])->first();
        if (!empty($page)) {

            $data = $this->makeData($request);
            // Encode content as JSON
            $content = json_encode($request->input('content'));
            $data['content'] = $content;
            try {
                $page->update($data);
                return successResponse('Page updated successfully');
            } catch (Exception $e) {
                return errorResponse($e -> getMessage());
            }
        }
    }

}
