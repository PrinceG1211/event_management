<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use App\Models\EventDetail;
use App\Models\EventBooking;
use App\Models\PackageDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class EventDetailController extends Controller
{

    public function index(): JsonResponse
    {
        $EventDetail =  EventDetail::where('isActive', 1)->with('Vendor')->get()->each(function ($EventDetail) {
         $EventDetail->vendorName= $EventDetail->Vendor->vendorName;
         $EventDetail->businessName= $EventDetail->Vendor->bname;
         $EventDetail->setHidden(['Vendor']);
        
       });  

        if ($EventDetail != null) {
            return $this->sendResponse('success', $EventDetail, ' EventDetail Found.');
        } else {
            return $this->sendResponse('failure', $EventDetail, 'No  EventDetail Found.');
        }

    }

    public function getbyevent($id): JsonResponse
    {
        $EventDetail =  EventDetail::where('isActive', 1)->where('eventID', $id)->get()->each(function ($EventDetail) {
            $EventDetail->vendorName= $EventDetail->Vendor->vendorName;
            $EventDetail->businessName= $EventDetail->Vendor->bname;
            $EventDetail->setHidden(['Vendor']);
           
          });  

       if ($EventDetail != null) {
        return $this->sendResponse('success', $EventDetail, ' EventDetail Found.');
    } else {
        return $this->sendResponse('failure', $EventDetail, 'No  EventDetail Found.');
    }
     }

    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'eventID' => 'required',
            'vendorID' => 'required',
            'date' => 'required',
            'cost' => 'required',
            'details' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $EventDetail = new EventDetail();
        $EventDetail->EventID = $request->post('eventID');
        $EventDetail->VendorID = $request->post('vendorID');
        $EventDetail->date = $request->post('date');
        $EventDetail->cost = $request->post('cost');
        $EventDetail->details = $request->post('details');
        $EventDetail->status = "Pending";
       
        $EventDetail->save();
        $EventBooking = EventBooking::where('isActive', 1)->where('bookingID', $EventDetail->EventID)->first();
         $packageData = PackageDetail::where('isActive',1)->where('packageID', $EventBooking->packageID)->first();
    
        $EventBooking->subTotal= (int)$EventBooking->subTotal + (int)$EventDetail->cost;
        $EventBooking->totalCost= (int)$EventBooking->subTotal+(int) $packageData->price;
        $EventBooking->save();

        return $this->sendResponse('success', $EventDetail->EventID, 'EventDetail created successfully.');
    }

    public function show($id): JsonResponse
    {
        $EventDetail = EventDetail::where('isActive', 1)->where('EventID', $id)->first();

        if (is_null($EventDetail)) {
            return $this->sendResponse('failure', $EventDetail, 'No EventDetail Found.');
        }

        return $this->sendResponse('success', $EventDetail, 'EventDetail Found.');
    }

    public function update(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'EventID' => 'required',
            // 'VendorID' => 'required',
            // 'date' => 'required',
            // 'cost' => 'required',
            // 'details' => 'required',
             'status' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $id = $request->post('eventID');
        $EventDetail = EventDetail::find($id);
        if ($EventDetail != null) {
            $EventDetail = new EventDetail();
            $EventDetail-> EventID   = $request->post('eventID');
            // $EventDetail->VendorID = $request->post('vendorID');
            // $EventDetail->date = $request->post('date');
            // $EventDetail->cost = $request->post('cost');
            // $EventDetail->details = $request->post('details');
            $EventDetail->status = $request->post('status');
           
            $updated = $EventDetail->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'EventDetail updated successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'EventDetail Not updated.');
            }

        } else {
            return $this->sendResponse('failure', $EventDetail, 'EventDetail Not Found.');
        }

    }

    public function delete(Request $request): JsonResponse
    {
        $id = $request->post('eventDetailID');
        $EventDetail = EventDetail::find($id);
        if ($EventDetail != null) {
            $EventDetail->isActive = 0;
            $updated = $EventDetail->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'EventDetail Deleted successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'EventDetail Not updated.');
            }
        } else {
            return $this->sendResponse('failure', $EventDetail, 'EventDetail Not Found.');
        }
    }
}
