<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Customer extends Model
{
    protected $table = 'customer_tb';
    protected $primaryKey='customerID';
    protected $fillable=[
        
        'name',
        'email',
        'mobileNo',     
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
