<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Auth extends Model
{
    protected $table = 'auth_tb';
    protected $primaryKey='authID';
    protected $fillable=[
        'userID',
        'userName',
        'password',
        'type',
        'email',
        'mobileNo',
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
