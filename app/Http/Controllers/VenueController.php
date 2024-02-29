<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use App\Models\Venue;
use App\Models\image;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class VenueController extends Controller
{

    public function index(): JsonResponse
    {
        $Venue = Venue::where('isActive', 1)->with('PackageDetail',)->get()->each(function ($Venue) {
            $Venue->packageName = $Venue->PackageDetail->packageName;  
            $Venue->setHidden(['PackageDetail']); 
         });
        if ($Venue != null) {
            return $this->sendResponse('success', $Venue, 'Venue Found.');
        } else {
            return $this->sendResponse('failure', $Venue, 'No Venue Found.');
        }

    }

    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
      
            'venueName' => 'required',
            'capacity' => 'required',
            'contactPerson' => 'required',
            'email' => 'required',
            'mobileNo' => 'required',
            'address' => 'required',
            'image' => 'required',
            'price' => 'required',
            'city' => 'required',
            'area' => 'required',
            'packageID' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $Venue = new Venue();
        
        
        $Venue->venueName = $request->post('venueName');
        $Venue->capacity = $request->post('capacity');
        $Venue->contactPerson = $request->post('contactPerson');
        $Venue->email = $request->post('email');
        $Venue->mobileNo = $request->post('mobileNo');
        $Venue->address = $request->post('address');
        $image= $request->file('image');
        $Venue->image= $this->uploadimage($image, "Venue");
        $Venue->price = $request->post('price');
        $Venue->city = $request->post('city');
        $Venue->area = $request->post('area');
        $Venue->packageID = $request->post('packageID');
        
        $Venue->save();

        
        return $this->sendResponse('success', $Venue->venueID, 'Venue Added successfully.');
    }

    public function show($id): JsonResponse
    {
        $Venue = Venue::where('isActive', 1)->where('VenueID', $id)->first();

        if (is_null($Venue)) {
            return $this->sendResponse('failure', $Venue, 'No Venue Found.');
        }

        return $this->sendResponse('success', $Venue, 'Venue Found.');
    }
    public function update(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [

            'venueID' => 'required',
            'venueName' => 'required',
            'capacity' => 'required',
            'contactPerson' => 'required',
            'email' => 'required',
            'mobileNo' => 'required',
            'address' => 'required',
            'image' => 'required',
            'price' => 'required',
            'city' => 'required',
            'area' => 'required',
            'packageID' => 'required',
           
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $id = $request->post('VenueID');
        $Venue = Venue::find($id);
        if ($Venue != null) {
            $Venue->VenueID = $request->post('VenueID');
            $Venue->venueName = $request->post('venueName');
            $Venue->capacity = $request->post('capacity');
            $Venue->contactPerson = $request->post('contactPerson');
            $Venue->email = $request->post('email');
            $Venue->mobileNo = $request->post('mobileNo');
            $Venue->address = $request->post('address');
            $image= $request->file('image');
            if($image != null){
                $Venue->image = $this->uploadImage($image, "Venue");
            }
            $Venue->price = $request->post('price');
            $Venue->city = $request->post('city');
            $Venue->area = $request->post('area');
            $Venue->packageID = $request->post('packageID');
            $updated = $Venue->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'Venue updated successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'Venue Not updated.');
            }

        } else {
            return $this->sendResponse('failure', $Venue, 'Venue Not Found.');
        }

    }

    public function delete(Request $request): JsonResponse
    {
        $id = $request->post('VenueID');
        $Venue = Venue::find($id);
        if ($Venue != null) {
            $Venue->isActive = 0;
            $updated = $Venue->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'Venue Deleted successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'Venue Not updated.');
            }
        } else {
            return $this->sendResponse('failure', $Venue, 'Venue Not Found.');
        }
    }

    public function deleteimages(Request $request): JsonResponse
    {
        $id = $request->post('imageID');
        $image= Venueimage::find($id);
        if ($image!= null) {
            $deleted = $this->deleteimage($image->image);
            if ($deleted) {
                $image->delete();
                return $this->sendResponse('success', $updated, 'imageDeleted successfully.');
            } else {
                return $this->sendResponse('failure', $updated, ' imageNot delete.');
            }
        } else {
            return $this->sendResponse('failure', $image, ' imageNot Found.');
        }
    }
}
