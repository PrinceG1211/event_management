<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use App\Models\Vendor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class VendorController extends Controller
{

    public function index(): JsonResponse
    {
       
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
            'mobileNo' => 'required',
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
        $Vendor->name = $request->post('name');
        $Vendor->email = $request->post('email');
        $Vendor->mobileNo = $request->post('mobileNo');
        $Vendor->dob = $request->post('dob');
        $Vendor->doj = $request->post('doj');
        $Vendor->type = $request->post('type');
        $Vendor->save();

        return $this->sendResponse('success', $Vendor->employeeID, 'Vendor Added successfully.');
    }

    public function show($id): JsonResponse
    {
        $Vendor = Vendor::where('isActive', 1)->where('employeeID', $id)->first();

        if (is_null($Vendor)) {
            return $this->sendResponse('failure', $Vendor, 'No Vendor Found.');
        }

        return $this->sendResponse('success', $Vendor, 'Vendor Found.');
    }
    public function update(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'employeeID' => 'required',
            'name' => 'required',
            'email' => 'required',
            'mobileNo' => 'required',
            'dob' => 'required',
            'doj' => 'required',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $id = $request->post('employeeID');
        $Vendor = Vendor::find($id);
        if ($Vendor != null) {
            $Vendor->name = $request->post('name');
            $Vendor->email = $request->post('email');
            $Vendor->mobileNo = $request->post('mobileNo');
            $Vendor->dob = $request->post('dob');
            $Vendor->doj = $request->post('doj');
            $Vendor->type = $request->post('type');
            
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
        $id = $request->post('employeeID');
        $Vendor = Vendor::find($id);
        if ($Vendor != null) {
            $Vendor->isActive = 0;
            $updated = $EmVendorployee->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'Vendor Deleted successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'Vendor Not updated.');
            }
        } else {
            return $this->sendResponse('failure', $Vendor, 'Vendor Not Found.');
        }
    }
}
