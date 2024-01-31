<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Area extends Model
{
    protected $table = 'area_tb';
    protected $primaryKey='areaID';
    protected $fillable=[
        'cityID',
        'areaName',
        'pincode',
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

     public function City()
     {
         return $this->belongsTo(City::class, 'cityID');

     }


}

?>
