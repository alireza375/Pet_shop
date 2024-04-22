<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceRequest;
use App\Http\Services\Admin\ServiceService;
use App\Http\Resources\Admin\ServiceResource;

class ServiceController extends Controller
{
    //
    private $ServiceService;

    public function __construct(ServiceService $ServiceService)
    {
        $this->ServiceService = $ServiceService;
    }

    public function index(Request $request){
        return $this->ServiceService->index($request);
    }

    public function show(Request $request)
    {
        $data = Service::find($request->_id);
        if (!$data) {
            return errorResponse(__('Service not found.'));
        }
        return successResponse(__('Service fetched successfully.'), ServiceResource::make($data) ?? $data);

    }


    public function AddorUpdate(ServiceRequest $request){
        if($request-> _id){
            return $this->ServiceService->Update($request);
        }else{
            return $this->ServiceService->Store($request);
        }
    }


    public function delete(Request $request){
        if($request->_id){
            $service = Service::find($request->_id);
            if($service){
                $service->delete();
                return successResponse('Service Delete SuccessFully');
            }
        }
        return errorResponse(__('Service Not Fount'));
    }



}
