<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class City extends Model
{
    protected $table = 'city_tb';
    protected $primaryKey='cityID';
    protected $fillable=[
        'cityName',
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
