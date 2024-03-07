<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use App\Models\EventBooking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class EventBookingController extends Controller
{

    public function index(): JsonResponse
    {
        $EventBooking = EventBooking::where('isActive', 1)->with('PackageDetail','Customer')->get()->each(function ($EventBooking) {  
       
            $EventBooking->customerName = $EventBooking->Customer->name;  
            $EventBooking->packageName = $EventBooking->PackageDetail->packageName;  
            $EventBooking->setHidden(['Customer','PackageDetail']);
         });
        if ($EventBooking != null) {
            return $this->sendResponse('success', $EventBooking, 'EventBooking Found.');
        } else {
            return $this->sendResponse('failure', $EventBooking, 'No EventBooking Found.');
        }

    }

    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'bookingType' => 'required',
            'customerID' => 'required',
            'bookingStartDate' => 'required',
            'bookingEndDate' => 'required',
            'noOfGuest' => 'required',
            'packageID' => 'required',
            
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $EventBooking = new EventBooking();
        $EventBooking->bookingType = $request->post('bookingType');
        $EventBooking->customerID = $request->post('customerID');
        $EventBooking->bookingDate = date('Y-m-d');
        $EventBooking->bookingStartDate = $request->post('bookingStartDate');
        $EventBooking->bookingEndDate = $request->post('bookingEndDate');
        $EventBooking->bookingStatus = "Pending";
        $EventBooking->noOfGuest = $request->post('noOfGuest');
        $EventBooking->subTotal = 0;
        $EventBooking->totalCost = 0;
        $EventBooking->packageID = $request->post('packageID');
       
        $EventBooking->save();

       
        return $this->sendResponse('success', $EventBooking->bookingID, 'EventBooking Added successfully.');
    }

    public function show($id): JsonResponse
    {
        $EventBooking = EventBooking::where('isActive', 1)->where('bookingID', $id)->first();

        if (is_null($EventBooking)) {
            return $this->sendResponse('failure', $EventBooking, 'No EventBooking Found.');
        }

        return $this->sendResponse('success', $EventBooking, 'EventBooking Found.');
    }
    public function update(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'bookingID' => 'required',
            'bookingType' => 'required',
            'eventID' => 'required',
            'customerID' => 'required',
            'bookingDate' => 'required',
            'bookingStartDate' => 'required',
            'bookingEndDate' => 'required',
            'bookingStatus' => 'required',
            'venue' => 'required',
            'noOfGuest' => 'required',
            'subTotal' => 'required',
            'totalCost' => 'required',
            'packageID' => 'required',
            
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $id = $request->post('bookingID');
        $EventBooking = EventBooking::find($id);
        if ($EventBooking != null) {
            $EventBooking->bookingID = $request->post('bookingID');
            $EventBooking->bookingType = $request->post('bookingType');
            $EventBooking->eventID = $request->post('eventID');
            $EventBooking->customerID = $request->post('customerID');
            $EventBooking->bookingDate = $request->post('bookingDate');
            $EventBooking->bookingStartDate = $request->post('bookingStartDate');
            $EventBooking->bookingEndDate = $request->post('bookingEndDate');
            $EventBooking->bookingStatus = $request->post('bookingStatus');
            $EventBooking->venue = $request->post('venue');
            $EventBooking->noOfGuest = $request->post('noOfGuest');
            $EventBooking->subTotal = $request->post('subTotal');
            $EventBooking->totalCost = $request->post('totalCost');
            $EventBooking->packageID = $request->post('packageID');
        
            
            $updated = $EventBooking->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'EventBooking updated successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'EventBooking Not updated.');
            }

        } else {
            return $this->sendResponse('failure', $EventBooking, 'EventBooking Not Found.');
        }

    }

    public function delete(Request $request): JsonResponse
    {
        $id = $request->post('bookingID');
        $EventBooking = EventBooking::find($id);
        if ($EventBooking != null) {
            $EventBooking->isActive = 0;
            $updated = $EventBooking->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'EventBooking Deleted successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'EventBooking Not updated.');
            }
        } else {
            return $this->sendResponse('failure', $EventBooking, 'EventBooking Not Found.');
        }
    }

   
}
