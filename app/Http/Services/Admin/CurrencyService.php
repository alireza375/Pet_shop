<?php

namespace App\Http\Services\Admin;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Casts\Json;

class CurrencyService
{
    public function show($request){

    }

    public function store($request){

        $data = $request->all();
        // where(['code', $request->code])->first();
        $check = Currency::where(['code' => $data['code']])->first();
        if (!empty($check)) {
            return errorResponse(__('Currency already exists'));
        }
        if($check){
            return errorResponse(__('Currency already exists'));
        }
        if(isset($data['default']) && $data['default'] == 1){
           $default = Currency::where(['default' => 1])->first();
           if($default){
               $default->default = 0;
               $default->save();
           }
        }
        $data = Currency::create($data);
        return successResponse(__('Currency successfully created'), $data);

    }

    public function update($request){
        $data = $request->all();
        $currency = Currency::where(['id' => $data['id']])->first();
        // dd($currency);
        if($currency){
            if($data['default'] == 1){
                $default = Currency::where(['default' => 1])->first();
                if($default){
                    $default->default = 0;
                    $default->save();
                }
            }
            if(isset($data['rate'])){
               $data['rate'] = json_decode($data['rate']);
            }
            $data = $currency->update($data);
            dd($data);
            return successResponse(__('Currency successfully updated'), $data);
        }
    }

}
