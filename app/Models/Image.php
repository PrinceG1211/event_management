<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Image extends Model
{
    protected $table = 'image_tb';
    protected $primaryKey='imageID';
    protected $fillable=[
        'productID',
        'type',
        'path',
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

    public function Product()
    {
        return $this->belongsTo(Product::class, 'productID');

    }
 }

?>
