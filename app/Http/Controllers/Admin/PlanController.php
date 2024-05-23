<?php

namespace App\Http\Controllers\Admin;

use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PlanRequest;
use App\Http\Services\Admin\PlanService;

class PlanController extends Controller
{
    //
    private $planService;

    public function __construct(PlanService $planService){
        $this -> planService = $planService;
    }

    public function index(Request $request)
    {
        return $this->planService->index($request);

    }

    public function show(Request $request){
        return $this->planService->show($request);
    }

    public function addOrUpdate(PlanRequest $request){
        if($request->_id){
            return $this->planService->update($request);
        }else{
            return $this->planService->store($request);
        }
    }

    public function delete(Request $request){
        try{
            $plan = Plan::find($request->_id);
            if(!$plan){
                return errorResponse(__('Plan not found.'));
            }
            $plan->delete();
            return successResponse(__('Plan has been deleted successfully.'));
        }catch (\Exception $exception){
            return errorResponse($exception->getMessage());
        }
        
    }


}
