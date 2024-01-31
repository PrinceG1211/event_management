<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Employee  extends Model
{
    protected $table = 'employee_tb';
    protected $primaryKey='employeeID';
    protected $fillable=[
        
        'name',
        'email',
        'mobileNo',
        'dob', 
        'doj', 
        'type',      
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
