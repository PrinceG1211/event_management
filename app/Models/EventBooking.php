<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class EventBooking extends Model
{
    protected $table = 'event_booking_tb';
    protected $primaryKey='bookingID';
    protected $fillable=[
        'bookingType',
        'eventID',
        'customerID',
        'bookingDate',
        'bookingStartDate',
        'bookingEndDate',
        'bookingStatus',
        'venue',
        'noOfGuest',
        'subTotal',
        'totalCost',
        'packageID',
        'isActive'
    ];
    protected $dates = [
        'addedOn',
        'updatedOn',
    ];
    const CREATED_AT = 'addedOn';
    const UPDATED_AT = 'updatedOn';
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->addedOn = $model->freshTimestamp();
        });

        static::updating(function ($model) {
            $model->updatedOn = $model->freshTimestamp();
        });
    }

     public function Customer()
     {
         return $this->belongsTo(Customer::class, 'customerID');

     }


     public function Package()
     {
         return $this->belongsTo(Package::class, 'packageID');

     }
}

?>
