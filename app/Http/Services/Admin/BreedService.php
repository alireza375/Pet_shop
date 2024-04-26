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
        // return $request->all();
        try {
            // Create a new Breed
            $traits = json_encode($request->input('traits'));
            $specifications = json_encode($request->input('specifications'));
            $data = array_merge($this->makeData($request), ['specifications' => $specifications, 'traits' => $traits]);

            $breed = Breed::create($data);
            return successResponse(__('Breed created successfully.'), $breed);
        } catch (\Exception $e) {
            return errorResponse($e->getMessage());
        }
    }


    public function update($request){
        try {
            $breed = Breed::find($request->_id);
            if ($breed) {
                // $data = $this->makeData($request);
                $traits = json_encode($request->input('traits'));
                $specifications = json_encode($request->input('specifications'));
                $data = array_merge($this->makeData($request), ['specifications' => $specifications, 'traits' => $traits]);


                // $breed->update($data);

                return $request->data;

            // return successResponse(__('Breed updated successfully'), $data);
            } else {
                return errorResponse(__('Breed not found'));
            }
        } catch (\Exception $e) {
            return errorResponse($e->getMessage());
        }
    }
}
