<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\Admin\SettingService;

class SettingController extends Controller
{
    //
    private $settingService;

    public function __construct(SettingService $settingService)
    {
       $this->settingService = $settingService;
    }


    // Add and Update Setting
    public function Settings(Request $request)
    {
        if (!empty($request->_id)) {
            return $this->settingService->update($request);
        } else {
            return $this->settingService->store($request);
        }
    }


    // Get Setting
    public function GetSetting()
    {
        return $this->settingService->getSettings();
    }
}
