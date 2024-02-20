<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Venue extends Model
{
    protected $table = 'venue_tb';
    protected $primaryKey='venueID';
    protected $fillable=[
        'venueName',
        'capacity',
        'contactPerson',
        'email',
        'mobileNo ',
        'address',
        'image',
        'price',
        'city',
        'area',
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

    public function PackageDetail()
    {
        return $this->belongsTo(PackageDetail::class, 'packageID');

    }
}

?>
 