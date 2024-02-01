<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::prefix('Area')->group( function () {
    Route::get('/',[AreaController::class,'index']);
    Route::get('/{id}',[AreaController::class,'show']);
    Route::post('add',[AreaController::class,'store']);
    Route::post('update',[AreaController::class,'update']);
    Route::post('delete',[AreaController::class,'delete']);
});

Route::prefix('Auth')->group( function () {
    Route::get('/',[AuthController::class,'index']);
    Route::get('/{id}',[AuthController::class,'show']);
    Route::post('add',[AuthController::class,'store']);
    Route::post('update',[AuthController::class,'update']);
    Route::post('delete',[AuthController::class,'delete']);
});

Route::prefix('City')->group( function () {
    Route::get('/',[CityController::class,'index']);
    Route::get('/{id}',[CityController::class,'show']);
    Route::post('add',[CityController::class,'store']);
    Route::post('update',[CityController::class,'update']);
    Route::post('delete',[CityController::class,'delete']);
});

Route::prefix('Customer')->group( function () {
    Route::get('/',[CustomerController::class,'index']);
    Route::get('/{id}',[CustomerController::class,'show']);
    Route::post('add',[CustomerController::class,'store']);
    Route::post('update',[CustomerController::class,'update']);
    Route::post('delete',[CustomerController::class,'delete']);
});

Route::prefix('Employee')->group( function () {
    Route::get('/',[EmployeeController::class,'index']);
    Route::get('/{id}',[EmployeeController::class,'show']);
    Route::post('add',[EmployeeController::class,'store']);
    Route::post('update',[EmployeeController::class,'update']);
    Route::post('delete',[EmployeeController::class,'delete']);
});

Route::prefix('EmployeeEvent')->group( function () {
    Route::get('/',[EmployeeEventController::class,'index']);
    Route::get('/{id}',[EmployeeEventController::class,'show']);
    Route::post('add',[EmployeeEventController::class,'store']);
    Route::post('update',[EmployeeEventController::class,'update']);
    Route::post('delete',[EmployeeEventController::class,'delete']);
});

Route::prefix('EventBooking')->group( function () {
    Route::get('/',[EventBookingController::class,'index']);
    Route::get('/{id}',[EventBookingController::class,'show']);
    Route::post('add',[EventBookingController::class,'store']);
    Route::post('update',[EventBookingController::class,'update']);
    Route::post('delete',[EventBookingController::class,'delete']);
});

Route::prefix('EventDetails')->group( function () {
    Route::get('/',[EventDeatilsController::class,'index']);
    Route::get('/{id}',[EventDeatilsController::class,'show']);
    Route::post('add',[EventDeatilsController::class,'store']);
    Route::post('update',[EventDeatilsController::class,'update']);
    Route::post('delete',[EventDeatilsController::class,'delete']);
});

Route::prefix('Hotel')->group( function () {
    Route::get('/',[HotelController::class,'index']);
    Route::get('/{id}',[HotelController::class,'show']);
    Route::get('images/{id}',[HotelController::class,'showImage']);
    Route::post('add',[HotelController::class,'store']);
    Route::post('update',[HotelController::class,'update']);
    Route::post('delete',[HotelController::class,'delete']);
});

Route::prefix('Inquiry')->group( function () {
    Route::get('/',[InquiryController::class,'index']);
    Route::get('/{id}',[InquiryController::class,'show']);
    Route::post('add',[InquiryController::class,'store']);
    Route::post('update',[InquiryController::class,'update']);
    Route::post('delete',[InquiryController::class,'delete']);
});

Route::prefix('PackageDeatils')->group( function () {
    Route::get('/',[PackageDeatilsController::class,'index']);
    Route::get('/{id}',[PackageDeatilsController::class,'show']);
    Route::post('add',[PackageDeatilsController::class,'store']);
    Route::post('update',[InquiryController::class,'update']);
    Route::post('delete',[InquiryController::class,'delete']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
