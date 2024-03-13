<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class EventDetail extends Model
{
    protected $table = 'event_detail_tb';
    protected $primaryKey='eventDetailID';
    protected $fillable=[
        'eventID',
        'vendorID',
        'date',
        'cost',
        'details',
        'type',
        'status',
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

     public function Vendor()
     {
         return $this->belongsTo(Vendor::class, 'vendorID');

     }
     public function Venue()
     {
         return $this->belongsTo(Venue::class, 'vendorID');

     }
}

?>
