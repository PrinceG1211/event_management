<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use App\Models\EmployeeEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class EmployeeEventController extends Controller
{

    public function index(): JsonResponse
    {
        $EmployeeEvent = EmployeeEvent::where('isActive', 1)->with('EmployeeEvent','Employee','Event')->get()->each(function ($EmployeeEvent,$employee,$event) {
         $EmployeeEvent->EmployeeEventID = $EmployeeEvent->Employee->EmployeeEventID;  
         $EmployeeEvent->EmployeeID = $EmployeeEvent->Employee->EmployeeID;
         $EmployeeEvent->EventID = $EmployeeEvent->Employee->EventID; // Add EmployeeEventID
       });

        if ($EmployeeEvent != null) {
            return $this->sendResponse('success', $EmployeeEvent, 'EmployeeEvent Found.');
        } else {
            return $this->sendResponse('failure', $EmployeeEvent, 'No EmployeeEvent Found.');
        }

    }

    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'EmployeeEventID' => 'required',
            'EmployeeID' => 'required',
            'EventID' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $EmployeeEvent = new EmployeeEvent();
        $EmployeeEvent-> EmployeeEventID = $request->post('EmployeeEventID');
        $EmployeeEvent->EmployeeID = $request->post('EmployeeID');
        $EmployeeEvent->EventID = $request->post('EventID');
       
        $product->save();

        return $this->sendResponse('success', $EmployeeEvent->EmployeeEventID, 'EmployeeEvent created successfully.');
    }

    public function show($id): JsonResponse
    {
        $EmployeeEvent = EmployeeEvent::where('isActive', 1)->where('EmployeeEventID', $id)->first();

        if (is_null($EmployeeEvent)) {
            return $this->sendResponse('failure', $EmployeeEvent, 'No EmployeeEvent Found.');
        }

        return $this->sendResponse('success', $EmployeeEvent, 'EmployeeEvent Found.');
    }

    public function update(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
           'EmployeeEventID' => 'required',
            'EmployeeID' => 'required',
            'EventID' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $id = $request->post('EmployeeEventID');
        $EmployeeEvent = EmployeeEvent::find($id);
        if ($EmployeeEvent != null) {
            $EmployeeEvent = new EmployeeEvent();
            $EmployeeEvent-> EmployeeEventID = $request->post('EmployeeEventID');
            $EmployeeEvent->EmployeeID = $request->post('EmployeeID');
            $EmployeeEvent->EventID = $request->post('EventID');
           
            $updated = $EmployeeEvent->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'EmployeeEvent updated successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'EmployeeEvent Not updated.');
            }

        } else {
            return $this->sendResponse('failure', $EmployeeEvent, 'EmployeeEvent Not Found.');
        }

    }

    public function delete(Request $request): JsonResponse
    {
        $id = $request->post('EmployeeEventID');
        $EmployeeEvent = EmployeeEvent::find($id);
        if ($EmployeeEvent != null) {
            $EmployeeEvent->isActive = 0;
            $updated = $EmployeeEvent->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'EmployeeEvent Deleted successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'EmployeeEvent Not updated.');
            }
        } else {
            return $this->sendResponse('failure', $EmployeeEvent, 'EmployeeEvent Not Found.');
        }
    }
}
