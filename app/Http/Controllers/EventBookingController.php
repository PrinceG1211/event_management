<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use App\Models\EventBooking;
use App\Models\EventDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class EventBookingController extends Controller
{

    public function index(): JsonResponse
    {
        $EventBooking = EventBooking::where('isActive', 1)->with('PackageDetail', 'Customer')->get()->each(function ($EventBooking) {

            $EventBooking->customerName = $EventBooking->Customer->name;
            $EventBooking->packageName = $EventBooking->PackageDetail->packageName;
            $EventBooking->setHidden(['Customer', 'PackageDetail']);
        });
        if ($EventBooking != null) {
            return $this->sendResponse('success', $EventBooking, 'EventBooking Found.');
        } else {
            return $this->sendResponse('failure', $EventBooking, 'No EventBooking Found.');
        }

    }
    public function income(): JsonResponse
    {
        $EventBooking = EventBooking::where('isActive', 1)->with('PackageDetail', 'Customer')->get()->each(function ($EventBooking) {
            $EventBooking->customerName = $EventBooking->Customer->name;
            $EventBooking->packageName = $EventBooking->PackageDetail->packageName;
            $EventBooking->setHidden(['Customer', 'PackageDetail']);
        });

        // Assuming 'price' is the attribute for package price in the PackageDetail model
        $totalPackagePrice = $EventBooking->sum(function ($booking) {
            return (float) $booking->PackageDetail->price; // Replace 'price' with the actual package price attribute
        });

        if ($EventBooking->isNotEmpty()) {
            // Include totalPackagePrice in the response
            $data = [
                'EventBookings' => $EventBooking,
                'TotalPackagePrice' => $totalPackagePrice,
            ];
            return $this->sendResponse('success', $data, 'EventBooking Found.');
        } else {
            return $this->sendResponse('failure', null, 'No EventBooking Found.');
        }
    }
    public function getbyVendorincome($id): JsonResponse
    {
        $eventDetails = EventDetail::where('isActive', 1)
            ->where('vendorID', $id)
            ->where('type', 'vendor')
            ->with('EventBooking')
            ->get();

            $totalPackagePrice = $eventDetails->sum(function ($booking) {
                return (float) $booking->cost; // Replace 'price' with the actual package price attribute
            });
    
            if ($eventDetails->isNotEmpty()) {
                // Include totalPackagePrice in the response
                $data = [
                    'TotalPackagePrice' => $totalPackagePrice,
                ];
                return $this->sendResponse('success', $data, 'EventBooking Found.');
            } else {
                return $this->sendResponse('failure', null, 'No EventBooking Found.');
            }
    }
    public function getbyeventbooking($id): JsonResponse
    {
        $EventBooking = EventBooking::where('isActive', 1)->where('customerID', $id)->with('PackageDetail', 'Customer')->get()->each(function ($EventBooking) {

            $EventBooking->customerName = $EventBooking->Customer->name;
            $EventBooking->packageName = $EventBooking->PackageDetail->packageName;
            $EventBooking->setHidden(['Customer', 'PackageDetail']);
        });

        if (is_null($EventBooking)) {
            return $this->sendResponse('failure', $EventBooking, 'No EventBooking Found.');
        }

        return $this->sendResponse('success', $EventBooking, 'EventBooking Found.');
    }

    public function getbyeventbookingvendor($id): JsonResponse
    {
        $eventDetails = EventDetail::where('isActive', 1)
            ->where('vendorID', $id)
            ->where('type', 'vendor')
            ->with('EventBooking')
            ->get();

// To show only EventBooking data from each EventDetail
        $eventBookings = $eventDetails->map(function ($eventDetail) {
// Assuming EventBooking is the relationship method name in your EventDetail model
            return $eventDetail->EventBooking; // This will return the EventBooking data for each EventDetail
        });

// If you want to filter out EventDetails that don't have any EventBooking data
        $eventBookings = $eventDetails->filter(function ($eventDetail) {
            return $eventDetail->EventBooking !== null; // Or use ->isNotEmpty() if EventBooking could be a collection
        })->map(function ($eventDetail) {
            return $eventDetail->EventBooking;
        });

        if (is_null($eventBookings)) {
            return $this->sendResponse('failure', $eventBookings, 'No EventBooking Found.');
        }

        return $this->sendResponse('success', $eventBookings, 'EventBooking Found.');
    }

    public function getbyeventbookingvenue($id): JsonResponse
    {
        $eventDetails = EventDetail::where('isActive', 1)
            ->where('vendorID', $id)
            ->where('type', 'venue')
            ->with('EventBooking')
            ->get();

// To show only EventBooking data from each EventDetail
        $eventBookings = $eventDetails->map(function ($eventDetail) {
// Assuming EventBooking is the relationship method name in your EventDetail model
            return $eventDetail->EventBooking; // This will return the EventBooking data for each EventDetail
        });

// If you want to filter out EventDetails that don't have any EventBooking data
        $eventBookings = $eventDetails->filter(function ($eventDetail) {
            return $eventDetail->EventBooking !== null; // Or use ->isNotEmpty() if EventBooking could be a collection
        })->map(function ($eventDetail) {
            return $eventDetail->EventBooking;
        });

        if (is_null($eventBookings)) {
            return $this->sendResponse('failure', $eventBookings, 'No EventBooking Found.');
        }

        return $this->sendResponse('success', $eventBookings, 'EventBooking Found.');
    }

    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'bookingType' => 'required',
            'customerID' => 'required',
            'bookingStartDate' => 'required',
            'bookingEndDate' => 'required',
            'noOfGuest' => 'required',
            'packageID' => 'required',

        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $EventBooking = new EventBooking();
        $EventBooking->bookingType = $request->post('bookingType');
        $EventBooking->customerID = $request->post('customerID');
        $EventBooking->bookingDate = date('Y-m-d');
        $EventBooking->bookingStartDate = $request->post('bookingStartDate');
        $EventBooking->bookingEndDate = $request->post('bookingEndDate');
        $EventBooking->bookingStatus = "Pending";
        $EventBooking->noOfGuest = $request->post('noOfGuest');
        $EventBooking->subTotal = 0;
        $EventBooking->totalCost = 0;
        $EventBooking->packageID = $request->post('packageID');

        $EventBooking->save();

        return $this->sendResponse('success', $EventBooking->bookingID, 'EventBooking Added successfully.');
    }

    public function show($id): JsonResponse
    {
        $EventBooking = EventBooking::where('isActive', 1)->where('bookingID', $id)->with('PackageDetail', 'Customer')->get()->each(function ($EventBooking) {

            $EventBooking->customerName = $EventBooking->Customer->name;
            $EventBooking->packageName = $EventBooking->PackageDetail->packageName;
            $EventBooking->setHidden(['Customer', 'PackageDetail']);
        });

        if (is_null($EventBooking)) {
            return $this->sendResponse('failure', $EventBooking[0], 'No EventBooking Found.');
        }

        return $this->sendResponse('success', $EventBooking[0], 'EventBooking Found.');
    }
    public function update(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'bookingID' => 'required',
            // 'bookingType' => 'required',
            // 'eventID' => 'required',
            // 'customerID' => 'required',
            // 'bookingDate' => 'required',
            // 'bookingStartDate' => 'required',
            // 'bookingEndDate' => 'required',
            'bookingStatus' => 'required',
            // 'venue' => 'required',
            // 'noOfGuest' => 'required',
            // 'subTotal' => 'required',
            // 'totalCost' => 'required',
            // 'packageID' => 'required',

        ]);

        if ($validator->fails()) {
            return $this->sendResponse('failure', 'Validation Error.', $validator->errors());
        }

        $id = $request->post('bookingID');
        $EventBooking = EventBooking::find($id);
        if ($EventBooking != null) {
            $EventBooking->bookingID = $request->post('bookingID');
            // $EventBooking->bookingType = $request->post('bookingType');
            // $EventBooking->eventID = $request->post('eventID');
            // $EventBooking->customerID = $request->post('customerID');
            // $EventBooking->bookingDate = $request->post('bookingDate');
            // $EventBooking->bookingStartDate = $request->post('bookingStartDate');
            // $EventBooking->bookingEndDate = $request->post('bookingEndDate');
            $EventBooking->bookingStatus = $request->post('bookingStatus');
            // $EventBooking->venue = $request->post('venue');
            // $EventBooking->noOfGuest = $request->post('noOfGuest');
            // $EventBooking->subTotal = $request->post('subTotal');
            // $EventBooking->totalCost = $request->post('totalCost');
            // $EventBooking->packageID = $request->post('packageID');

            $updated = $EventBooking->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'EventBooking updated successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'EventBooking Not updated.');
            }

        } else {
            return $this->sendResponse('failure', $EventBooking, 'EventBooking Not Found.');
        }

    }

    public function delete(Request $request): JsonResponse
    {
        $id = $request->post('bookingID');
        $EventBooking = EventBooking::find($id);
        if ($EventBooking != null) {
            $EventBooking->isActive = 0;
            $updated = $EventBooking->save();
            if ($updated == 1) {
                return $this->sendResponse('success', $updated, 'EventBooking Deleted successfully.');
            } else {
                return $this->sendResponse('failure', $updated, 'EventBooking Not updated.');
            }
        } else {
            return $this->sendResponse('failure', $EventBooking, 'EventBooking Not Found.');
        }
    }

}
