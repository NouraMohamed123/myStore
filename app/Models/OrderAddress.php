<?php

namespace App\Models;

use Symfony\Component\Intl\Countries;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderAddress extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getCountryNameAttribute()
    {
        return Countries::getName($this->country);
    }
}