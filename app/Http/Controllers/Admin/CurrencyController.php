<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CurrencyRequest;
use App\Http\Services\Admin\CurrencyService;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    //
    private $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function index(Request $request)
    {
        // return $this->currencyService->index($request);
    }

    public function show(Request $request)
    {
        return $this->currencyService->show($request);
    }

    public function addOrUpdate(CurrencyRequest $request)
    {
        if($request->_id){
            return $this->currencyService->update($request);
        }else{
            return $this->currencyService->store($request);
        }
    }

    public function delete(Request $request)
    {
        // return $this->currencyService->destroy($request);
    }
}
