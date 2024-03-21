<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeEventController;
use App\Http\Controllers\EventBookingController;
use App\Http\Controllers\EventDetailController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\PackageDetailController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\VendorCategoryController;
use App\Http\Controllers\VenueController;

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
    Route::post('login',[AuthController::class,'login']);
    Route::post('adminlogin',[AuthController::class,'adminlogin']);
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
    Route::get('getbyeventid/{id}',[EmployeeEventController::class,'getbyeventid']);
    Route::post('add',[EmployeeEventController::class,'store']);
    Route::post('update',[EmployeeEventController::class,'update']);
    Route::post('delete',[EmployeeEventController::class,'delete']);
});

Route::prefix('EventBooking')->group( function () {
    Route::get('/',[EventBookingController::class,'index']);
    Route::get('income',[EventBookingController::class,'income']);
    Route::get('/{id}',[EventBookingController::class,'show']);
    Route::get('getbyeventbooking/{id}',[EventBookingController::class,'getbyeventbooking']);
    Route::get('getbyeventbookingVendor/{id}',[EventBookingController::class,'getbyeventbookingvendor']);
    Route::get('getbyeventbookingVenue/{id}',[EventBookingController::class,'getbyeventbookingvenue']);
    Route::post('add',[EventBookingController::class,'store']);
    Route::post('update',[EventBookingController::class,'update']);
    Route::post('delete',[EventBookingController::class,'delete']);
});

Route::prefix('EventDetail')->group( function () {
    Route::get('/',[EventDetailController::class,'index']);
    Route::get('/{id}',[EventDetailController::class,'show']);
    Route::get('getbyevent/{id}',[EventDetailController::class,'getbyevent']);
    Route::get('getbyeventVendor/{id}/{vendorID}',[EventDetailController::class,'getbyeventVendor']);
    Route::get('getbyeventVenue/{id}/{vendorID}',[EventDetailController::class,'getbyeventVenue']);
    Route::post('add',[EventDetailController::class,'store']);
    Route::post('update',[EventDetailController::class,'update']);
    Route::post('delete',[EventDetailController::class,'delete']);
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

Route::prefix('PackageDetail')->group( function () {
    Route::get('/',[PackageDetailController::class,'index']);
    Route::get('/{id}',[PackageDetailController::class,'show']);
    Route::post('add',[PackageDetailController::class,'store']);
    Route::post('update',[PackageDetailController::class,'update']);
    Route::post('delete',[PackageDetailController::class,'delete']);
});

Route::prefix('Vendor')->group( function () {
    Route::get('/',[VendorController::class,'index']);
    Route::get('/{id}',[VendorController::class,'show']);
    Route::get('images/{id}',[VendorController::class,'showImage']);
    Route::post('category',[VendorController::class,'category']);
    Route::post('add',[VendorController::class,'store']);
    Route::post('update',[VendorController::class,'update']);
    Route::post('delete',[VendorController::class,'delete']);
});

Route::prefix('VendorCategory')->group( function () {
    Route::get('/',[VendorCategoryController::class,'index']);
    Route::get('/parent',[VendorCategoryController::class,'parentCategory']);
    Route::post('getCategory',[VendorCategoryController::class,'getCategory']);
    Route::get('/{id}',[VendorCategoryController::class,'show']);
    Route::get('images/{id}',[VendorCategoryController::class,'showImage']);
    Route::post('add',[VendorCategoryController::class,'store']);
    Route::post('update',[VendorCategoryController::class,'update']);
    Route::post('delete',[VendorCategoryController::class,'delete']);
});

Route::prefix('Venue')->group( function () {
    Route::get('/',[VenueController::class,'index']);
    Route::get('/{id}',[VenueController::class,'show']);
    Route::get('images/{id}',[VenueController::class,'showImage']);
    Route::post('add',[VenueController::class,'store']);
    Route::post('update',[VenueController::class,'update']);
    Route::post('delete',[VenueController::class,'delete']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
