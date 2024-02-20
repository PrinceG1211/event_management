<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use App\Models\PackageDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class PackageDetailController extends Controller
{

    public function index(): JsonResponse
    {
       
        $PackageDetail = PackageDetail::where('isActive', 1)->get();
        if ($PackageDetail != null) {
            return $this->sendResponse('success', $PackageDetail, 'PackageDetail Found.');
        } else {
            return $this->sendResponse('failure', $PackageDetail, 'No PackageDetail Found.');
        }

    }

    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            
        
            'packageName' => 'required',
            'packageDescription' => 'required',
            'price' => 'required',
          
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $PackageDetail = new PackageDetail();
        
        $PackageDetail->packageName = $request->post('packageName');
        $PackageDetail->packageDescription = $request->post('packageDescription');
        $PackageDetail->price = $request->post('price');
        
       
        $PackageDetail->save();

        return $this->sendResponse('success', $PackageDetail->packageID, 'PackageDetail Added successfully.');
    }

    public function show($id): JsonResponse
    {
        $PackageDetail = PackageDetail::where('isActive', 1)->where('packageID', $id)->first();

        if (is_null($PackageDetail)) {
            return $this->sendResponse('failure', $PackageDetail, 'No PackageDetail Found.');
        }

        return $this->sendResponse('success', $PackageDetail, 'PackageDetail Found.');
    }
    public function update(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'packageID' => 'required',
            'packageName' => 'required',
            'packageDescription' => 'required',
            'price' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $id = $request->post('packageID');
        $PackageDetail = PackageDetail::find($id);
        if ($PackageDetail != null) {
            $PackageDetail->packageID = $request->post('packageID');
            $PackageDetail->packageName = $request->post('packageName');
            $PackageDetail->packageDescription = $request->post('packageDescription');
            $PackageDetail->price = $request->post('price');

            $updated = $PackageDetail->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'PackageDetail updated successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'PackageDetail Not updated.');
            }

        } else {
            return $this->sendResponse('failure', $PackageDetail, 'PackageDetail Not Found.');
        }

    }

    public function delete(Request $request): JsonResponse
    {
        $id = $request->post('packageID');
        $PackageDetail = PackageDetail::find($id);
        if ($PackageDetail != null) {
            $PackageDetail->isActive = 0;
            $updated = $PackageDetail->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'PackageDetail Deleted successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'PackageDetail Not updated.');
            }
        } else {
            return $this->sendResponse('failure', $PackageDetail, 'PackageDetail Not Found.');
        }
    }
}
