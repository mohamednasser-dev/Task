<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function getImageAttribute($image)
    {
        if (!empty($image)) {
            return asset('public/uploads/products') . '/' . $image;
        }
        return asset('public/uploads/products/default.jpg');
    }

    public function setImageAttribute($image)
    {
        if (is_file($image)) {
            $imageFields = upload($image, 'products');
            $this->attributes['image'] = $imageFields;
        }
    }
}
