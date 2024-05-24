<?php

namespace App\Http\Services\Admin;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Casts\Json;
use App\Http\Resources\Admin\CurrencyResource;

class CurrencyService
{
    public function show($request){
        $data = Currency::find(['id', $request->id]);
        try{
            if (!$data) {
                return errorResponse(__('Currency not found.'));
            }
            return successResponse(__('Currency fetched successfully.'), CurrencyResource::collection( $data));

        }catch (\Exception $e){
            return errorResponse($e->getMessage());
        }

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
        // dd($data);
        if(isset($data['default']) && $data['default'] == 1){
            $default = Currency::where(['default' => 1])->first();
            if($default){
                $default->default = 0;
                $default->save();
            }
        }
        if(isset($data['rate'])){
            $data['rate'] = json_encode($data['rate']);
        }
        $data = Currency::find($request->id)->update($data);
        return successResponse(__('Currency successfully updated'), $data);
        // dd($currency);

    }

}
