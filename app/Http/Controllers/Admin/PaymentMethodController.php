<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PaymentMethodRequest;
use App\Http\Resources\Admin\PaymentMethodResource;
use App\Http\Services\Admin\PaymentMethodService;
use App\Http\Resources\Pagination\BasePaginationResource;

class PaymentMethodController extends Controller
{
    //
    private $PaymentMethod;
    public function __construct(PaymentMethodService $paymentMethod)
    {
        $this -> PaymentMethod = $paymentMethod;
    }

    public function index(Request $request)
    {
        $per_page = $request->per_page ?? PERPAGE_PAGINATION;
        $data = PaymentMethod::paginate($per_page);
        return successResponse(__('PaymentMethods fetched successfully.'), new BasePaginationResource(PaymentMethodResource::collection($data)));
    }

    public function show(Request $request){
        return $this->PaymentMethod->show($request);
    }

    public function addOrUpdate(PaymentMethodRequest $request)
    {
        if($request->_id){
            return $this->PaymentMethod->update($request);
        }else{
            return $this->PaymentMethod->store($request);
        }
    }

    public function delete(Request $request){
        try {
            $PaymentMethod = PaymentMethod::find($request->id);
            if (!$PaymentMethod) {
                return errorResponse(__('PaymentMethod not found.'));
            }
            $PaymentMethod->delete();
            return successResponse(__('PaymentMethod deleted successfully.'));
        } catch (\Exception $e) {
            return errorResponse($e->getMessage());
        }
    }


}
