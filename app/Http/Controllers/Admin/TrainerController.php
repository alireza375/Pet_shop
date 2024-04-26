<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TrainerRequest;
use App\Http\Services\Admin\TrainerService;
use App\Http\Resources\Admin\TrainerResource;
use App\Http\Resources\Pagination\BasePaginationResource;

class TrainerController extends Controller
{
    //
    private $TrainerService;

    public function __construct(TrainerService $TrainerService)
    {
        $this->TrainerService = $TrainerService;
    }

    public function index(Request $request){
            $per_page = $request->per_page ?? PERPAGE_PAGINATION;
            $data = User::where(['role' => TRAINER])->paginate($per_page);
            $data = TrainerResource::collection($data);
            return successResponse(__('Users fetched successfully.'), new BasePaginationResource($data));
    }

    public function AddTrainer(TrainerRequest $request){
        return $this->TrainerService->store($request);
    }

    public function delete(Request $request){
        if($request->_id){
            $trainer = User::find($request->_id);
            if($trainer){
                $trainer->delete();
                return successResponse('Trainer Delete SuccessFully');
            }
        }
        return errorResponse(__('Trainer Not Fount'));
    }
}
