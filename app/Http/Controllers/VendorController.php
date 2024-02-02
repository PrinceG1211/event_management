<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use App\Models\Vendor;
use App\Models\Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class VendorController extends Controller
{

    public function index(): JsonResponse
    {
        $Vendor = Vendor::where('isActive', 1)->with('Vendor','Package',)->get()->each(function ($Vendor,$Package) {
            $Vendor->vendorID = $Vendor->Vendor->vendorID;
            $Vendor->packageId = $Vendor->Package->packageID;  
         });
        $Vendor = Vendor::where('isActive', 1)->get();
        if ($Vendor != null) {
            return $this->sendResponse('success', $Vendor, 'Vendor Found.');
        } else {
            return $this->sendResponse('failure', $Vendor, 'No Vendor Found.');
        }

    }

    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            
            'bname' => 'required',
            'vendorName' => 'required',
            'contactPerson' => 'required',
            'email' => 'required',
           'contactNo'=>'required',
            'address' => 'required',
            'category' => 'required',
            'packageID' => 'required',
            'price' => 'required',
            'image' => 'required',
            
            
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $Vendor = new Vendor();
        $Vendor->vendorID = $request->post('vendorID');
        $Vendor->bname = $request->post('bname');
        $Vendor->vendorName = $request->post('vendorName');
        $Vendor->contactPerson = $request->post('contactPerson');
        $Vendor->email = $request->post('email');
        $Vendor->address = $request->post('address');
        $Vendor->category = $request->post('category');
        $Vendor->packageID = $request->post('packageID');
        $Vendor->price = $request->post('price');
        $Vendor->image = $request->post('image');
      
        $Vendor->save();

        $images = $request->file('images');
       

        return $this->sendResponse('success', $Vendor->vendorID, 'Vendor Added successfully.');
    }

    public function show($id): JsonResponse
    {
        $Vendor = Vendor::where('isActive', 1)->where('vendorID', $id)->first();

        if (is_null($Vendor)) {
            return $this->sendResponse('failure', $Vendor, 'No Vendor Found.');
        }

        return $this->sendResponse('success', $Vendor, 'Vendor Found.');
    }
    public function update(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
          
            'bname' => 'required',
            'vendorName' => 'required',
            'contactPerson' => 'required',
            'email' => 'required',
           'contactNo'=>'required',
            'address' => 'required',
            'category' => 'required',
            'packageID' => 'required',
            'price' => 'required',
            'image' => 'required',
            
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $id = $request->post('vendorID');
        $Vendor = Vendor::find($id);
        if ($Vendor != null) {
            $Vendor->vendorID = $request->post('vendorID');
            $Vendor->bname = $request->post('bname');
            $Vendor->vendorName = $request->post('vendorName');
            $Vendor->contactPerson = $request->post('contactPerson');
            $Vendor->email = $request->post('email');
           
            $Vendor->address = $request->post('address');
            $Vendor->category = $request->post('category');
            $Vendor->packageID = $request->post('packageID');
            $Vendor->price = $request->post('price');
            $Vendor->image = $request->post('image');
           
            
            $updated = $Vendor->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'Vendor updated successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'Vendor Not updated.');
            }

        } else {
            return $this->sendResponse('failure', $Vendor, 'Vendor Not Found.');
        }

    }

    public function delete(Request $request): JsonResponse
    {
        $id = $request->post('vendorID');
        $Vendor = Vendor::find($id);
        if ($Vendor != null) {
            $Vendor->isActive = 0;
            $updated = $Vendor->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'Vendor Deleted successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'Vendor Not updated.');
            }
        } else {
            return $this->sendResponse('failure', $Vendor, 'Vendor Not Found.');
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
