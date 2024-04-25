<?php

namespace App\Http\Services\Admin;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductService
{

    public function makeData($request)
    {
        $data = [
            'name' => $request->get('name'),
            'price' => $request->get('price'),
            'category_id' => $request->get('category'),
            'images' => $request->hasFile('images') ? uploadMultipleImages($request->file('images')) : null,
            'short_description' => $request->get('short_description'),
            'description' => $request->get('description'),
            'weight' => $request->get('weight'),
            'sku_code' => $request->get('sku_code'),
        ];
        return $data;
    }

    //show data by id
    public function getproduct($request)
    {
        $product = Product::with('brand')->find($request->_id);
        if (!$product) {
            return errorResponse(__('Product not found'));
        }

        // Retrieve related products from the same category
        $relatedProducts = Product::where('brand_id', $product->brand_id)
            ->where('id', '!=', $product->id)
            ->limit(2)
            ->get(['id', 'name', 'price']);

        // Calculate total number of reviews and average rating for the product
        // $totalReviews = $product->reviews()->count();
        // Change made here: Formatting average rating to two decimal places and casting to float
        // $averageRating = (float) number_format($product->reviews()->avg('rating'), 2);
        // Prepare the response data
        $responseData = [
            'product' => [
                '_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'weight' => $product->weight,
                'sku_code' => $product->sku_code,
                'brand' => [
                    '_id' => $product->brand->id,
                    'name' => $product->brand->name,
                ],
                'images' => $product->images, // Decode the images if they are stored as JSON
                'short_description' => $product->short_description,
                'description' => $product->description,
                'createdAt' => $product->created_at,
                'updatedAt' => $product->updated_at,
            ],
            // 'reviewStats' => [
            //     '_id' => null,
            //     'totalReviews' => $totalReviews,
            //     'averageRating' => $averageRating,
            // ],
            'relatedProducts' => $relatedProducts,
        ];
        return successResponse(__('Successfully gets product'), $responseData);
    }


    //store
    public function store($request)
    {
        try {
            $product = Product::create($request->all());
            return successResponse(__('Product created Successfully'), $product);
        } catch (\Exception $e) {
            return errorResponse($e->getMessage());
        }
    }


    //update
    public function update($request)
    {
        $data = $this->makeData($request);
        $product = Product::find($request->_id);
        if (!$product) {
            return errorResponse(__('Product not found'));
        }
        // Ensure $prevImages is always an array
        $prevImages = $request->has('prev_images') ? (array) $request->get('prev_images') : [];
        foreach ($prevImages as $imageUrl) {
            $deleted = fileRemoveAWS($imageUrl);
            if (!$deleted) {
                return errorResponse(__('Failed to delete one or more images'));
            }
        }
        try {
            $product->update($data);
            return successResponse(__('Successfully updated Product'));
        } catch (\Exception $e) {
            return errorResponse($e->getMessage());
        }
    }



}
