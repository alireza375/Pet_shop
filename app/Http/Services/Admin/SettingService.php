<?php

namespace App\Http\Services\Admin;

use App\Models\Setting;

class SettingService
{
    public function makeData($request)
    {
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            // 'logo' => $request->hasFile('logo') ? fileUploadAWS($request->file('logo'), 'one-ride-storage/files') :  null,
            'logo' => $request->hasFile('logo') ? fileUpload($request->file('logo'), public_path("Auth") ) :  null,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'instagram' => $request->instagram,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'youtube' => $request->youtube,
            'linkedin' => $request->linkedin,
            'whatsapp' => $request->whatsapp,
        ];
        return $data;
    }


    //Add Setting
    public function store($request)
    {
        try {
            $data = $this->makeData($request); // Call makeData function to prepare data
            $setting = Setting::create($data);
            return successResponse(__('Settings created Successfully'), $setting);
        } catch (\Exception $e) {
            return errorResponse($e->getMessage());
        }
    }


    // update Setting
    public function update($request)
    {
        $setting = Setting::first();
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'logo' => $request->hasFile('logo') ? fileUpload($request->file('logo'), public_path("Auth") ) :  null,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'instagram' => $request->instagram,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'youtube' => $request->youtube,
            'linkedin' => $request->linkedin,
            'whatsapp' => $request->whatsapp,
        ];
        if (!$setting) {
            Setting::create($data);
            return successResponse(__('Setting added successfully'));
        } else {
            $setting->update($data);
            return successResponse(__('Setting updated successfully.'));
        }
    }



    // get Settings
    public function getSettings()
    {
        $setting = Setting::first();
        if ($setting) {
            $data = [
                '_id' => $setting->id,
                'title' => $setting->title,
                'description' => $setting->description,
                'logo' => $setting->logo,
                'email' => $setting->email,
                'phone' => $setting->phone,
                'address' => $setting->address,
                'instagram' => $setting->instagram,
                'facebook' => $setting->facebook,
                'twitter' => $setting->twitter,
                'youtube' => $setting->youtube,
                'whatsapp' => $setting->whatsapp,
            ];
            return successResponse(__('Setting fetched successfully.'), $data);
        } else {
            return successResponse(__('setting not found.'), null);
        }
    }

}
