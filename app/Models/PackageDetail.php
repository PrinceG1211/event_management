<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class PackageDetail extends Model
{
    protected $table = 'package_tb';
    protected $primaryKey='packageID';
    protected $fillable=[
        'packageName',
        'packageDiscription',
        'price',    
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

}

?>
