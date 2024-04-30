<?php

namespace App\Http\Services\Admin;

use App\Models\Breed;

class BreedService
{

    public function makeData($request){
        $data = [
            'image' =>$request->hasFile('image') ? fileUpload($request->file('image'), PATH_GALLERIES) :  null,
            'name' => $request->name,
            'description' => $request->description,
            'origin'=>$request->origin,
            'year_recognized' => $request->year_recognized,
            'traits' => $request->traits,
            'specifications' => $request->specifications
        ];
        return $data;
    }



    public function store($request){
        try {
            // Create a new Breed
            $traits = json_encode($request->input('traits'));
            $specifications = json_encode($request->input('specifications'));
            $breed = Breed::create(array_merge($this->makeData($request), ['specifications' => $specifications, 'traits' => $traits]));

            // $breed = Breed::create($data);
            return successResponse(__('Breed created successfully.'), $breed);
        } catch (\Exception $e) {
            return errorResponse($e->getMessage());
        }
    }


    public function update($request){
        $breed = Breed::find($request->_id);
        if (!empty($breed)) {
            try {
                // Update the breed's data
                $traits = json_encode($request->input('traits'));
                $specifications = json_encode($request->input('specifications'));
                $data = $this->makeData($request);
                // return $request->all();
                $data['specifications'] = $specifications;
                $data['traits'] = $traits;
                if ($request->hasFile('image')) {
                    $data['image'] = fileUpload($request->file('image'), PATH_GALLERIES);
                }

                // Update the breed with the new data
                $breed->update($data);

                // Return success response
                return successResponse(__('Breed updated successfully'), $breed);

            } catch (\Exception $e) {
                // Return error response if an exception occurs
                return errorResponse($e->getMessage());
            }
        } else {
            // Return error response if breed is not found
            return errorResponse(__('Breed not found'));
        }
    }




}
