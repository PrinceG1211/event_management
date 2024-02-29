<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use App\Models\VendorCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class VendorCategoryController extends Controller
{

    public function index(): JsonResponse
    {
    
     
        $Category = VendorCategory::where('isActive', 1)->get();
        $VendorCategory = array();
        foreach($Category as $cat){
            $cat['parentName'] = "";
            if($cat['parentID'] != "0"){
                $parentCat = VendorCategory::where('isActive', 1)->where('categoryID', $cat['parentID'])->first();
                if($parentCat != null){
                    $cat['parentName'] = $parentCat['categoryName'];
                }
                
            }
            array_push($VendorCategory,$cat);
        }
        if ($VendorCategory != null) {
            return $this->sendResponse('success', $VendorCategory, 'Vendor Category Found.');
        } else {
            return $this->sendResponse('failure', $VendorCategory, 'No Vendor Category Found.');
        }

    }

    
    public function parentCategory(): JsonResponse
    {
         $VendorCategory = VendorCategory::where('isActive', 1)->where('parentID', 0)->get();
        if ($VendorCategory != null) {
            return $this->sendResponse('success', $VendorCategory, 'Vendor Category Found.');
        } else {
            return $this->sendResponse('failure', $VendorCategory, 'No Vendor Category Found.');
        }

    }

    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            
            'categoryName' => 'required',
            'parentID' => 'required',
            
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $VendorCategory = new VendorCategory();
        $VendorCategory->categoryID = $request->post('categoryID');
        $VendorCategory->categoryName = $request->post('categoryName');
        $VendorCategory->parentID = $request->post('parentID');
       
        $VendorCategory->save();

        return $this->sendResponse('success', $VendorCategory->categoryID, 'Vendor Category Added successfully.');
    }

    public function show($id): JsonResponse
    {
        $VendorCategory = VendorCategory::where('isActive', 1)->where('categoryID', $id)->first();

        if (is_null($VendorCategory)) {
            return $this->sendResponse('failure', $VendorCategory, 'No Vendor Category Found.');
        }

        return $this->sendResponse('success', $VendorCategory, 'Vendor Category Found.');
    }
    public function update(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'categoryID' => 'required',
            'categoryName' => 'required',
            'parentID' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $id = $request->post('categoryID');
        $VendorCategory = VendorCategory::find($id);
        if ($VendorCategory != null) {
            $VendorCategory->categoryName = $request->post('categoryName');
            $VendorCategory->parentID = $request->post('parentID');
            
            $updated = $VendorCategory->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'Vendor Category updated successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'Vendor Category Not updated.');
            }

        } else {
            return $this->sendResponse('failure', $VendorCategory, 'Vendor Category Not Found.');
        }

    }

    public function delete(Request $request): JsonResponse
    {
        $id = $request->post('categoryID');
        $VendorCategory = VendorCategory::find($id);
        if ($VendorCategory != null) {
            $VendorCategory->isActive = 0;
            $updated = $VendorCategory->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'Vendor Category Deleted successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'Vendor Category Not updated.');
            }
        } else {
            return $this->sendResponse('failure', $VendorCategory, 'Vendor Category Not Found.');
        }
    }
}
