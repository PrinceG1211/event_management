<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class VendorCategory extends Model
{
    protected $table = 'auth_tb';
    protected $primaryKey='categoryID';
    protected $fillable=[
        'categoryName',
        'parentID',
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

 


}

?>
