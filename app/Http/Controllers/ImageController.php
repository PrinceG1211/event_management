<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use App\Models\Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class ImageController extends Controller
{

    public function index(): JsonResponse
    {
        $Vendor = Image::where('isActive', 1)->with('Image','product',)->get()->each(function ($Image,$product) {
            $Image->ImageID = $Image->Image->ImageID;
            $Image->productID = $Image->product->productID;  
         });
        $Image = Image::where('isActive', 1)->get();
        if ($Image != null) {
            return $this->sendResponse('success', $Image, 'Image Found.');
        } else {
            return $this->sendResponse('failure', $Image, 'No Image Found.');
        }

    }

    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            
            'imageID' => 'required',
            'productID' => 'required',
            'type' => 'required',
            'path' => 'required',
            
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $Image = new Image();
        $Image->imageID = $request->post('imageID');
        $Image->productID = $request->post('productID');
        $Image->type = $request->post('type');
        $Image->path = $request->post('path');
        $Image->save();

       

        return $this->sendResponse('success', $image->imageID, 'image Added successfully.');
    }

    public function show($id): JsonResponse
    {
        $image = image::where('isActive', 1)->where('imageID', $id)->first();

        if (is_null($image)) {
            return $this->sendResponse('failure', $image, 'No image Found.');
        }

        return $this->sendResponse('success', $image, 'image Found.');
    }
    public function update(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'imageID' => 'required',
            'productID' => 'required',
            'type' => 'required',
            'path' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $id = $request->post('imageID');
        $image = image::find($id);
        if ($image != null) {
           
        $Image = new Image();
        $Image->imageID = $request->post('imageID');
        $Image->productID = $request->post('productID');
        $Image->type = $request->post('type');
        $Image->path = $request->post('path');
        $Image->save();

          
            
            $updated = $Image->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'Image updated successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'Image Not updated.');
            }

        } else {
            return $this->sendResponse('failure', $Image, 'Image Not Found.');
        }

    }

    public function delete(Request $request): JsonResponse
    {
        $id = $request->post('imageID');
        $Vendor = Image::find($id);
        if ($Image != null) {
            $Image->isActive = 0;
            $updated = $Image->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'Image Deleted successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'Image Not updated.');
            }
        } else {
            return $this->sendResponse('failure', $Image, 'Image Not Found.');
        }
    }

    
}
