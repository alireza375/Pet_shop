<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TrainerRequest;
use App\Http\Services\Admin\TrainerService;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    //
    private $TrainerService;

    public function __construct(TrainerService $TrainerService)
    {
        $this->TrainerService = $TrainerService;
    }

    public function AddTrainer(TrainerRequest $request){
        return $this->TrainerService->store($request);
    }
}
