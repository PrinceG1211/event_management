<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Vendor extends Model
{
    protected $table = 'vendor_tb';
    protected $primaryKey='vendorID';
    protected $fillable=[
        'bname',
        'vendorName',
        'contactPerson',
        'email',
        'contactNo ',
        'address',
        'category',
        'packageID',
        'price',
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
 