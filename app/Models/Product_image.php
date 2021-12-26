<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product_image extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function getImageAttribute($image)
    {
        if (!empty($image)) {
            return asset('public/uploads/products') . '/' . $image;
        }
        return asset('public/uploads/product_images/default.jpg');
    }

    public function setImageAttribute($image)
    {
        if (is_file($image)) {
            $imageFields = upload($image, 'product_images');
            $this->attributes['image'] = $imageFields;
        }
    }
}
