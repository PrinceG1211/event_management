<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    
    public function sendResponse($status,$result,$massage)
    {
        $response =[
            'status'=> $status,
            'data'=> $result,
            'massage'=>$massage,
        ];

        return response()->json($response,200);
    }

    public function uploadImage($image, $path)
    {
        $uploaded_path = $image->storeAs
            ($path, Str::random(40) . '.' . $image->getClientOriginalExtension(), ['disk' => 'public_uploads']);
        return $uploaded_path;
    }

    public function deleteImage($path)
    {
        if(Storage::disk("public_uploads")->exists($path)){
            Storage::disk("public_uploads")->delete($path);
            return true;
        }else{
            return false;
        }
    }
}