<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use App\Models\Employee;
use App\Models\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class EmployeeController extends Controller
{

    public function index(): JsonResponse
    {
       
        $Employee = Employee::where('isActive', 1)->get();
        if ($Employee != null) {
            return $this->sendResponse('success', $Employee, 'Employee Found.');
        } else {
            return $this->sendResponse('failure', $Employee, 'No Employee Found.');
        }

    }

    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            
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

        $Employee = new Employee();
        $Employee->employeeID = $request->post('employeeID');
        $Employee->name = $request->post('name');
        $Employee->email = $request->post('email');
        $Employee->mobileNo = $request->post('mobileNo');
        $Employee->dob = $request->post('dob');
        $Employee->doj = $request->post('doj');
        $Employee->type = $request->post('type');
       
        $Employee->save();

        
        $Auth = new Auth();
        $Auth->userID = $Employee->employeeID;
        $Auth->userName = $Employee->name;
        $Auth->password = $request->post('mobileNo');
        $Auth->type ="Employee";
        $Auth->email = $request->post('email');
        $Auth->mobileNo = $request->post('mobileNo');
       
        $Auth->save();
        return $this->sendResponse('success', $Employee->employeeID, 'Employee Added successfully.');
    }

    public function show($id): JsonResponse
    {
        $Employee = Employee::where('isActive', 1)->where('employeeID', $id)->first();

        if (is_null($Employee)) {
            return $this->sendResponse('failure', $Employee, 'No Employee Found.');
        }

        return $this->sendResponse('success', $Employee, 'Employee Found.');
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
        $Employee = Employee::find($id);
        if ($Employee != null) {
            $Employee->name = $request->post('name');
            $Employee->email = $request->post('email');
            $Employee->mobileNo = $request->post('mobileNo');
            $Employee->dob = $request->post('dob');
            $Employee->doj = $request->post('doj');
            $Employee->type = $request->post('type');
            
            $updated = $Employee->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'Employee updated successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'Employee Not updated.');
            }

        } else {
            return $this->sendResponse('failure', $Employee, 'Employee Not Found.');
        }

    }

    public function delete(Request $request): JsonResponse
    {
        $id = $request->post('employeeID');
        $Employee = Employee::find($id);
        if ($Employee != null) {
            $Employee->isActive = 0;
            $updated = $Employee->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'Employee Deleted successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'Employee Not updated.');
            }
        } else {
            return $this->sendResponse('failure', $Employee, 'Employee Not Found.');
        }
    }
}