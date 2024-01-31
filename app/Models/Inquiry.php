<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Inquiry extends Model
{
    protected $table = 'inquiry_tb';
    protected $primaryKey='inquiryID';
    protected $fillable=[
        'name',
        'email',
        'mobileNo',  
        'subject',
        'status',
        'discription',  
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
