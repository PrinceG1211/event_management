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
        'status',
        'isActive'
    ];
    protected $dates = [
        'addedOn',
        'updatedOn',
    ];

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
}

?>
