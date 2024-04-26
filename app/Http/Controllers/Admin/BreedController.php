<?php

namespace App\Http\Controllers\Admin;

use App\Models\Breed;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BreedRequest;
use App\Http\Services\Admin\BreedService;
use App\Http\Resources\Pagination\BasePaginationResource;

class BreedController extends Controller
{
    //
    private $breed;

    public function __construct(BreedService $breed)
    {
        $this->breed = $breed;
    }


    public function index(Request $request){
        $per_page = $request->per_page ?? PERPAGE_PAGINATION;
        $data = Breed::select('id as _id', 'image', 'name','description', 'created_at as createdAt', 'updated_at as updatedAt')->paginate($per_page);
        return successResponse(__('Breed fetched successfully.'), new BasePaginationResource($data));
    }


    public function addOrUpdate(BreedRequest $request){
        if($request->_id){
            return $this->breed->update($request);
        }else{
            return $this->breed->store($request);
        }
    }

    public function delete(Request $request){
        try {
            $breed = Breed::find($request->_id);
            if (!$breed) {
                return errorResponse(__('Breed not found.'));
            }
            $breed->delete();
            return successResponse(__('Breed deleted successfully.'));
        } catch (\Exception $e) {
            return errorResponse($e->getMessage());
        }
    }
}
