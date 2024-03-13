<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use App\Models\Customer;
use App\Models\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class CustomerController extends Controller
{

    public function index(): JsonResponse
    {
       
        $Customer = Customer::where('isActive', 1)->get();
        if ($Customer != null) {
            return $this->sendResponse('success', $Customer, 'Customer Found.');
        } else {
            return $this->sendResponse('failure', $Customer, 'No Customer Found.');
        }

    }

    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
           
            'name' => 'required',
            'email' => 'required',
            'mobileNo' => 'required',
            
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $Customer = new Customer();
        $Customer->CustomerID = $request->post('customerID');
        $Customer->name = $request->post('name');
        $Customer->email = $request->post('email');
        $Customer->mobileNo = $request->post('mobileNo');
       
        $Customer->save();

        $Auth = new Auth();
        $Auth->userID = $Customer->customerID;
        $Auth->userName = $Customer->name;
        $Auth->password = $request->post('password');
        $Auth->type ="Customer";
        $Auth->email = $request->post('email');
        $Auth->mobileNo = $request->post('mobileNo');
       
        $Auth->save();

        return $this->sendResponse('success', $Customer->customerID, 'Customer Added successfully.');
    }

    public function show($id): JsonResponse
    {
        $Customer = Customer::where('isActive', 1)->where('customerID', $id)->first();

        if (is_null($Customer)) {
            return $this->sendResponse('failure', $Customer, 'No Customer Found.');
        }

        return $this->sendResponse('success', $Customer, 'Customer Found.');
    }
    public function update(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required',
            'mobileNo' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $id = $request->post('customerID');
        $Customer = Customer::find($id);
        if ($Customer != null) {
            
            $Customer->name = $request->post('name');
            $Customer->email = $request->post('email');
            $Customer->mobileNo = $request->post('mobileNo');
            $updated = $Customer->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'Customer updated successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'Customer Not updated.');
            }

        } else {
            return $this->sendResponse('failure', $Auth, 'Customer Not Found.');
        }

    }

    public function delete(Request $request): JsonResponse
    {
        $id = $request->post('customerID');
        $Customer = Customer::find($id);
        if ($Customer != null) {
            $Customer->isActive = 0;
            $updated = $Customer->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'Customer Deleted successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'Customer Not updated.');
            }
        } else {
            return $this->sendResponse('failure', $Customer, 'Customer Not Found.');
        }
    }
}
