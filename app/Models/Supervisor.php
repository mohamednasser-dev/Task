<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Supervisor extends Authenticatable
{
    use HasFactory, SoftDeletes ;
    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function setPasswordAttribute($password)
    {
        if (!empty($password)) {
            $this->attributes['password'] = Hash::make($password);
        }
    }

    public function getImageAttribute($image)
    {
        if (!empty($image)) {
            return asset('public/uploads/supervisors') . '/' . $image;
        }
        return asset('public/uploads/supervisors/default.jpg');
    }

    public function setImageAttribute($image)
    {
        if (is_file($image)) {
            $imageFields = upload($image, 'supervisors');
            $this->attributes['image'] = $imageFields;
        }
    }
}
