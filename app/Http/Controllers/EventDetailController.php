<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use App\Models\EmployeeDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class EmployeeDetailController extends Controller
{

    public function index(): JsonResponse
    {
        $EmployeeDetail = EmployeeDetail::where('isActive', 1)->with('Event','Vendor')->get()->each(function ($event,$Vendor) {
         $EmployeeDetail->EventID = $EmployeeDetail->EmployeeDetail->EventID;  
         $EmployeeDetail->VendorID = $EmployeeDetail->EmployeeDetail->VendorID;
       });

        if ($EmployeeEvent != null) {
            return $this->sendResponse('success', $EmployeeDetail, 'EmployeeDetail Found.');
        } else {
            return $this->sendResponse('failure', $EmployeeDetail, 'No EmployeeDetail Found.');
        }

    }

    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'EventID' => 'required',
            'VendorID' => 'required',
            'date' => 'required',
            'cost' => 'required',
            'details' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $EmployeeDetail = new EmployeeDetail();
        $EmployeeDetail-> EventID = $request->post('EventID');
        $EmployeeDetail->VendorID = $request->post('VendorID');
        $EmployeeDetail->date = $request->post('date');
        $EmployeeDetail->cost = $request->post('cost');
        $EmployeeDetail->details = $request->post('details');
        $EmployeeDetail->status = $request->post('status');
       
        $product->save();

        return $this->sendResponse('success', $EmployeeDetail->EventID, 'EmployeeDetail created successfully.');
    }

    public function show($id): JsonResponse
    {
        $EmployeeDetail = EmployeeDetail::where('isActive', 1)->where('EventID', $id)->first();

        if (is_null($EmployeeDetail)) {
            return $this->sendResponse('failure', $EmployeeDetail, 'No EmployeeDetail Found.');
        }

        return $this->sendResponse('success', $EmployeeDetail, 'EmployeeDetail Found.');
    }

    public function update(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'EventID' => 'required',
            'VendorID' => 'required',
            'date' => 'required',
            'cost' => 'required',
            'details' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $id = $request->post('EmployeeDetail');
        $EmployeeDetail = EmployeeDetail::find($id);
        if ($EmployeeDetail != null) {
            $EmployeeDetail = new EmployeeDetail();
            $EmployeeDetail-> EventID = $request->post('EventID');
            $EmployeeDetail->VendorID = $request->post('VendorID');
            $EmployeeDetail->date = $request->post('date');
            $EmployeeDetail->cost = $request->post('cost');
            $EmployeeDetail->details = $request->post('details');
            $EmployeeDetail->status = $request->post('status');
           
            $updated = $EmployeeDetail->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'EmployeeDetail updated successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'EmployeeDetail Not updated.');
            }

        } else {
            return $this->sendResponse('failure', $EmployeeDetail, 'EmployeeDetail Not Found.');
        }

    }

    public function delete(Request $request): JsonResponse
    {
        $id = $request->post('EventID');
        $EmployeeDetail = EmployeeDetail::find($id);
        if ($EmployeeDetail != null) {
            $EmployeeDetail->isActive = 0;
            $updated = $EmployeeDetail->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'EmployeeDetail Deleted successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'EmployeeDetail Not updated.');
            }
        } else {
            return $this->sendResponse('failure', $EmployeeDetail, 'EmployeeDetail Not Found.');
        }
    }
}
