<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use App\Models\City;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class CityController extends Controller
{

    public function index(): JsonResponse
    {
       
        $City = City::where('isActive', 1)->get();
        if ($City != null) {
            return $this->sendResponse('success', $City, 'City Found.');
        } else {
            return $this->sendResponse('failure', $City, 'No City Found.');
        }

    }

    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'cityName' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $City = new city();
        $City->cityID = $request->post('cityID');
        $City->cityName = $request->post('cityName');
       
        $City->save();

        return $this->sendResponse('success', $City->cityID, 'City Added successfully.');
    }

    public function show($id): JsonResponse
    {
        $City = City::where('isActive', 1)->where('cityID', $id)->first();

        if (is_null($City)) {
            return $this->sendResponse('failure', $City, 'No City Found.');
        }

        return $this->sendResponse('success', $City, 'City Found.');
    }
    public function update(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'cityID' => 'required',
            'cityName' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $id = $request->post('cityID');
        $City = City::find($id);
        if ($City != null) {
            $City->cityName = $request->post('cityName');
            
            $updated = $City->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'City updated successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'City Not updated.');
            }

        } else {
            return $this->sendResponse('failure', $City, 'City Not Found.');
        }

    }

    public function delete(Request $request): JsonResponse
    {
        $id = $request->post('cityID');
        $City = City::find($id);
        if ($City != null) {
            $City->isActive = 0;
            $updated = $City->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'City Deleted successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'City Not updated.');
            }
        } else {
            return $this->sendResponse('failure', $City, 'City Not Found.');
        }
    }
}
