<?php

namespace App\Http\Services\Admin;

use App\Models\PaymentMethod;
use App\Http\Resources\Admin\PaymentMethodResource;

class PaymentMethodService
{
    public function makeData($request){
        $data = [
            'name' => $request->name,
            'type' => $request->type,
            'config' => json_encode($request->config),
        ];
        return $data;
    }

    public function show($request){
        try{
            $data = PaymentMethod::find(['id', $request->id])->first();
            if(!$data){
                return errorResponse(__('Payment Method not found'));
            }
            return successResponse(__('Payment Method fetched successfully.'), new PaymentMethodResource($data));
        }catch(\Exception $e){
            return errorResponse($e->getMessage());
        }
    }

    public function store($request){
        try {
            $type = PaymentMethod::where('type', $request->type)->first();
            if (!empty($type)) {
                return errorResponse(__('Payment Method alreay existed'));
            }
            $data = $this->makeData($request);
            $paymentMethod = PaymentMethod::create($data);
            return successResponse(__('Payment Method created successfully.'), $paymentMethod);
        } catch (\Exception $e) {
            return errorResponse($e->getMessage());
        }
    }

    public function update($request){
       $payment = PaymentMethod::where(['id' => $request->_id])->first();
       if (!$payment) {
        return errorResponse(__('Payment Method not found'));
       }
       $type = PaymentMethod::where('type', $request->type)->first();
       if (!$type) {
        return errorResponse(__('Payment Method not found'));
       }
       try {
        $data = $this->makeData($request);
        $payment->update($data);
        return successResponse(__('Payment Method updated successfully.'), $payment);
       } catch (\Exception $e) {
        return errorResponse($e->getMessage());
       }
    }

}
