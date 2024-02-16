<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use App\Models\Inquiry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class InquiryController extends Controller
{

    public function index(): JsonResponse
    {
       
        $Inquiry = Inquiry::where('isActive', 1)->get();
        if ($Inquiry != null) {
            return $this->sendResponse('success', $Inquiry, 'Inquiry Found.');
        } else {
            return $this->sendResponse('failure', $Inquiry, 'No Inquiry Found.');
        }

    }

    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            
            
            'name' => 'required',
            'email' => 'required',
            'mobileNo' => 'required',
            'subject' => 'required',
            'status' => 'required',
            'description' => 'required',
          
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $Inquiry = new Inquiry();
       
        $Inquiry->name = $request->post('name');
        $Inquiry->email = $request->post('email');
        $Inquiry->mobileNo = $request->post('mobileNo');
        $Inquiry->subject = $request->post('subject');
        $Inquiry->status = $request->post('status');
        $Inquiry->description = $request->post('description');
        
       
        $Inquiry->save();

        return $this->sendResponse('success', $Inquiry->Inquiry, 'Inquiry Added successfully.');
    }

    public function show($id): JsonResponse
    {
        $Inquiry = Inquiry::where('isActive', 1)->where('inquiryID', $id)->first();

        if (is_null($Inquiry)) {
            return $this->sendResponse('failure', $Inquiry, 'No Inquiry Found.');
        }

        return $this->sendResponse('success', $Inquiry, 'Inquiry Found.');
    }
    public function update(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
              
            'inquiryID' => 'required',
            'name' => 'required',
            'email' => 'required',
            'mobileNo' => 'required',
            'subject' => 'required',
            'status' => 'required',
            'description' => 'required',

        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $id = $request->post('inquiryID');
        $Inquiry = Inquiry::find($id);
        if ($Inquiry != null) {
            $Inquiry->inquiryID = $request->post('inquiryID');
            $Inquiry->name = $request->post('name');
            $Inquiry->email = $request->post('email');
            $Inquiry->mobileNo = $request->post('mobileNo');
            $Inquiry->subject = $request->post('subject');
            $Inquiry->status = $request->post('status');
            $Inquiry->description = $request->post('description');
            
            $updated = $Inquiry->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'Inquiry updated successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'Inquiry Not updated.');
            }

        } else {
            return $this->sendResponse('failure', $Inquiry, 'Inquiry Not Found.');
        }

    }

    public function delete(Request $request): JsonResponse
    {
        $id = $request->post('inquiryID');
        $Inquiry = Inquiry::find($id);
        if ($Inquiry != null) {
            $Inquiry->isActive = 0;
            $updated = $Inquiry->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'Inquiry Deleted successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'Inquiry Not updated.');
            }
        } else {
            return $this->sendResponse('failure', $Inquiry, 'Inquiry Not Found.');
        }
    }
}
