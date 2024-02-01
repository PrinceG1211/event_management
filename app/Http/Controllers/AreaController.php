<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use App\Models\Area;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class AreaController extends Controller
{

    public function index(): JsonResponse
    {
        $Area = Area::where('isActive', 1)->with('Area','City')->get()->each(function ($Area,$City) {
            $Area->cityID = $Area->City->cityID; 
        });
        $Area = Area::where('isActive', 1)->get();
        if ($Area != null) {
            return $this->sendResponse('success', $Area, ' Area Found.');
        } else {
            return $this->sendResponse('failure', $Area, 'Area Not Found.');
        }

    }

    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'cityID' => 'required',
            'areaName' => 'required',
            'pincode' => 'required',
            
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $Area = new Area();
        $Area->areaID = $request->post('areaID');
        $Area->cityID = $request->post('cityID');
        $Area->areaName = $request->post('areaName');
        $Area->pincode = $request->post('pincode');
       
        $Area->save();

        return $this->sendResponse('success', $Area->categoryID, 'Area Added successfully.');
    }

    public function show($id): JsonResponse
    {
        $Area = Area::where('isActive', 1)->where('areaID', $id)->first();

        if (is_null($Area)) {
            return $this->sendResponse('failure', $Area, 'Area Not Found.');
        }

        return $this->sendResponse('success', $Area, 'Area Found.');
    }
    public function update(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'areaID' => 'required',
            'cityID' => 'required',
            'areaName' => 'required',
            'pincode' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $id = $request->post('areaID');
        $Area = Area::find($id);
        if ($Area != null) {
            $Area->cityID = $request->post('cityID');
            $Area->areaName = $request->post('areaName');
            $Area->pincode = $request->post('pincode');
            
            $updated = $Area->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'Area updated successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'Area Not updated.');
            }

        } else {
            return $this->sendResponse('failure', $Area, 'Area Not Found.');
        }

    }

    public function delete(Request $request): JsonResponse
    {
        $id = $request->post('areaID');
        $Area = Area::find($id);
        if ($Area != null) {
            $Area->isActive = 0;
            $updated = $Area->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'Area Deleted successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'Area Not updated.');
            }
        } else {
            return $this->sendResponse('failure', $Area, 'Area Not Found.');
        }
    }
}
