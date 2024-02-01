<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use App\Models\Vendor;
use App\Models\Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class HotelController extends Controller
{

    public function index(): JsonResponse
    {
        $Hotel = Hotel::where('isActive', 1)->with('Hotel','Package',)->get()->each(function ($Hotel,$Package) {
            $Hotel->hotelID = $Hotel->Hotel->hotelID;  
            $Hotel->Package = $Hotel->Package->packageID;  
         });
        $Hotel = Hotel::where('isActive', 1)->get();
        if ($Hotel != null) {
            return $this->sendResponse('success', $Hotel, 'Hotel Found.');
        } else {
            return $this->sendResponse('failure', $Hotel, 'No Hotel Found.');
        }

    }

    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            
            'packageID' => 'required',
            'hotelname' => 'required',
            'rating' => 'required',
            'email' => 'required',
            'mobileNo' => 'required',
            'address' => 'required',
            'city' => 'required',
            'area' => 'required',
            'image' => 'required',
            'coverImage' => 'required|image|max:2048',
            
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $Hotel = new Hotel();
        $Hotel->hotelID = $request->post('hotelID');
        $Hotel->packageID = $request->post('packageID');
        $Hotel->hotelname = $request->post('hotelname');
        $Hotel->rating = $request->post('rating');
        $Hotel->email = $request->post('email');
        $Hotel->mobileNo = $request->post('mobileNo');
        $Hotel->address = $request->post('address');
        $Hotel->city = $request->post('category');
        $Hotel->area = $request->post('category');
      
        $Hotel->image = $request->post('image');
        $coverImage = $request->file('coverImage');
        $Hotel->coverImage = $this->uploadImage($coverImage, "Hotel");
        $Hotel->save();
        $images = $request->file('images');
        foreach($images as $image){
            $Image = new Image();
            $Image->productID=$product->productID;
            $Image->path = $this->uploadImage($image, "product");
            $Image->save();
        }

        return $this->sendResponse('success', $Hotel->hotelID, 'Hotel Added successfully.');
    }

    public function show($id): JsonResponse
    {
        $Hotel = Hotel::where('isActive', 1)->where('hotelID', $id)->first();

        if (is_null($Vendor)) {
            return $this->sendResponse('failure', $Hotel, 'No Hotel Found.');
        }

        return $this->sendResponse('success', $Hotel, 'Hotel Found.');
    }
    public function update(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'packageID' => 'required',
            'hotelname' => 'required',
            'rating' => 'required',
            'email' => 'required',
            'mobileNo' => 'required',
            'address' => 'required',
            'city' => 'required',
            'area' => 'required',
            'image' => 'required',
            'coverImage' => 'required|image|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $id = $request->post('employeeID');
        $Vendor = Vendor::find($id);
        if ($Vendor != null) {
            $Hotel->hotelID = $request->post('hotelID');
        $Hotel->packageID = $request->post('packageID');
        $Hotel->hotelname = $request->post('hotelname');
        $Hotel->rating = $request->post('rating');
        $Hotel->email = $request->post('email');
        $Hotel->mobileNo = $request->post('mobileNo');
        $Hotel->address = $request->post('address');
        $Hotel->city = $request->post('category');
        $Hotel->area = $request->post('category');
      
        $Hotel->image = $request->post('image');
        $coverImage = $request->file('coverImage');
        $Hotel->coverImage = $this->uploadImage($coverImage, "Hotel");
            if($coverImage!=""){
                $product->coverImage = $this->uploadImage($coverImage, "product");
            }
            
            $updated = $Hotel->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'Hotel updated successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'Hotel Not updated.');
            }

        } else {
            return $this->sendResponse('failure', $Hotel, 'Hotel Not Found.');
        }

    }

    public function delete(Request $request): JsonResponse
    {
        $id = $request->post('hotelID');
        $Hotel = Hotel::find($id);
        if ($Hotel != null) {
            $Hotel->isActive = 0;
            $updated = $Hotel->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'Hotel Deleted successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'Hotel Not updated.');
            }
        } else {
            return $this->sendResponse('failure', $Hotel, 'Hotel Not Found.');
        }
    }

    public function deleteImages(Request $request): JsonResponse
    {
        $id = $request->post('imageID');
        $Image = ProductImage::find($id);
        if ($Image != null) {
            $deleted = $this->deleteImage($Image->image);
            if ($deleted) {
                $Image->delete();
                return $this->sendResponse('success', $updated, 'Image Deleted successfully.');
            } else {
                return $this->sendResponse('failure', $updated, ' Image Not delete.');
            }
        } else {
            return $this->sendResponse('failure', $Image, ' Image Not Found.');
        }
    }
}
