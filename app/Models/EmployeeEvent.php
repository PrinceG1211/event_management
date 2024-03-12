<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class EmployeeEvent extends Model
{
    protected $table = 'employee_event_tb';
    protected $primaryKey='employeeEventID';
    protected $fillable=[
        'employeeID',
        'eventID',
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

     public function Employee()
     {
         return $this->belongsTo(Employee::class, 'employeeID');

     }

     public function EventBooking()
     {
         return $this->belongsTo(EventBooking::class, 'eventID');

     }

     public function EventBooking()
     {
         return $this->belongsTo(EventBooking::class, 'eventID');

     }

}

?>
