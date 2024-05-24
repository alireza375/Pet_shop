<?php

namespace App\Http\Controllers\Admin;

use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CurrencyRequest;
use App\Http\Resources\Admin\CurrencyResource;
use App\Http\Services\Admin\CurrencyService;
use App\Http\Resources\Pagination\BasePaginationResource;

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
        $per_page = $request->per_page ?? PERPAGE_PAGINATION;
        $currency = Currency::paginate($per_page);
        return successResponse(__('Currencies fetched successfully.'), new BasePaginationResource(CurrencyResource::collection($currency)));

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
        $currency = Currency::find($request->id);
        try{
            if($currency){
                $currency->delete();
                return successResponse(__('Currency deleted successfully.'));
            }
            return errorResponse(__('Currency not found.'));
        }catch (\Exception $exception){
            return errorResponse($exception->getMessage());
        }

    }
}
