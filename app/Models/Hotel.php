<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Hotel extends Model
{
    protected $table = 'hotel_tb';
    protected $primaryKey='hotelID';
    protected $fillable=[
        'packageID',
        'hotelname',
        'rating',
        'email',
        'mobileNo',  
        'address',
        'city',
        'area',
        'image',   
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

    public function Package()
    {
        return $this->belongsTo(Package::class, 'packageID');

    }

}

?>
