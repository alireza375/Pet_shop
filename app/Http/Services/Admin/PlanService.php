<?php

namespace App\Http\Services\Admin;

use App\Models\Plan;
use PhpParser\Node\Stmt\TryCatch;
use App\Http\Resources\Admin\PlanResource;
use App\Http\Resources\Pagination\BasePaginationResource;

class PlanService
{
    public function makeData($request){
        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'slug' => $request->slug,
            'credits' => $request->credits,
            'type' => $request->plan_type == "regular" ? 0 : 1,
            'features' => json_encode($request->features),
            'minimum' => $request->minimum_buying,
            'status' => $request->is_active == "true" ? 1 : 0,
        ];
        return $data;
    }

    public function index($request)
    {
        $per_page = $request->per_page ?? PERPAGE_PAGINATION;
        $plans = Plan::query();
        $plans->when(!empty(request('search')), function ($q) use ($request) {
            return $q->where(function ($q) use ($request) {
                return $q->where('name', 'like', '%' . $request->search . '%');
            });
        });
        $plans = $plans->paginate($per_page);
        return successResponse(__('Plans fetched successfully.'),new BasePaginationResource(PlanResource::collection($plans)));
    }

    public function show($request)
    {
        $data = Plan::find($request->_id);
        if (!$data) {
            return errorResponse(__('Plan not found.'));
        }
        return successResponse(__('Plan fetched successfully.'), PlanResource::make($data) ?? $data);

    }

    public function store($request)
    {
        try{
            $plan = Plan::create($this->makeData($request));
            return successResponse(__('Plan created successfully.'), $plan);
        }catch(\Exception $e){
            return errorResponse($e->getMessage());
        }

    }

    public function update($request)
    {
        $plan = Plan::where(['id' => $request->_id])->first();
        if (!empty($plan)) {
            $data = $this->makeData($request);
            try {
                $plan->update($data);
                return successResponse(__('Plan updated successfully'), $data);
            } catch (\Exception $e) {
                return errorResponse($e -> getMessage());
            }
        }
    }


}
