<?php

namespace App\Http\Services\Admin;

use App\Models\Newsletter;

class NewsletterService
{
    public function makeData($request){
        $data = [
            'email' => $request->get('email'),
            'id' => $request->get('id')
        ];
        return $data;
    }


    public function newsletter($request){

        $checkEmail = Newsletter::where('email', $request->email)->first();
        if ($checkEmail) {
            return errorResponse(__('Email already exists.'));
        }
        try {
            // Create a new contact
            $newsletter = Newsletter::create($request->all());
            // Set the reply field to null for new contacts
            $newsletter->save();

            return successResponse(__('Newsletter created successfully.'));
        } catch (\Exception $e) {
            return errorResponse($e->getMessage());
        }
    }


}
