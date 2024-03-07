<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use App\Models\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class AuthController extends Controller
{

    public function index(): JsonResponse
    {
       
        $Auth = Auth::where('isActive', 1)->get();
        if ($Auth != null) {
            return $this->sendResponse('success', $Auth, 'Auth Found.');
        } else {
            return $this->sendResponse('failure', $Auth, 'No Auth Found.');
        }

    }

    public function login(Request $request): JsonResponse
    {
        $email=$request->post('email');
        $password=$request->post('password');
        $Auth = Auth::where('isActive', 1)->where('email', $email)->where('password', $password)->first();
        if ($Auth != null) {
            return $this->sendResponse('success', $Auth, 'Auth Found.');
        } else {
            return $this->sendResponse('failure', $Auth, 'No Auth Found.');
        }

    }

    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'userID' => 'required',
            'userName' => 'required',
            'password' => 'required',
            'type' => 'required',
            'email' => 'required',
            'mobileNo' => 'required',
            
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $Auth = new Auth();
        $Auth->authID = $request->post('authID');
        $Auth->userID = $request->post('userID');
        $Auth->userName = $request->post('userName');
        $Auth->password = $request->post('password');
        $Auth->type = $request->post('type');
        $Auth->email = $request->post('email');
        $Auth->mobileNo = $request->post('mobileNo');
       
        $Auth->save();

        return $this->sendResponse('success', $Auth->authID, 'Auth Added successfully.');
    }

    public function show($id): JsonResponse
    {
        $Auth = Auth::where('isActive', 1)->where('authID', $id)->first();

        if (is_null($Auth)) {
            return $this->sendResponse('failure', $Auth, 'No Auth Found.');
        }

        return $this->sendResponse('success', $Auth, 'Auth Found.');
    }
    public function update(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'authID' => 'required',
            'userID' => 'required',
            'userName' => 'required',
            'password' => 'required',
            'type' => 'required',
            'email' => 'required',
            'mobileNo' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $id = $request->post('authID');
        $Auth = Auth::find($id);
        if ($Auth != null) {
            $Auth->userID = $request->post('userID');
            $Auth->userName = $request->post('userName');
            $Auth->password = $request->post('password');
            $Auth->type = $request->post('type');
            $Auth->email = $request->post('email');
            $Auth->mobileNo = $request->post('mobileNo');

            
            $updated = $Auth->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'Auth updated successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'Auth Not updated.');
            }

        } else {
            return $this->sendResponse('failure', $Auth, 'Auth Not Found.');
        }

    }

    public function delete(Request $request): JsonResponse
    {
        $id = $request->post('authID');
        $Auth = Auth::find($id);
        if ($Auth != null) {
            $Auth->isActive = 0;
            $updated = $Auth->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'Auth Deleted successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'Auth Not updated.');
            }
        } else {
            return $this->sendResponse('failure', $Auth, 'Auth Not Found.');
        }
    }
}
