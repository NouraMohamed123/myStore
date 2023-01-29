<?php

namespace App\Models;

use App\Observers\CartObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 use Str;
class Cart extends Model
{
    use HasFactory;

    public $incrementing = false;
     protected $guarded =[];
      
   //  Events
  protected static function booted(){
     static::observe(CartObserver::class);
     
         
      //   static::creating(function (Cart $cart){
      //     $cart->id = Str::uuid();
      //   });
     }
      
     public function user(){
        return $this->belongsTo('App\Models\User')->withDefault([
            'name' =>'Anouminus'
        ]);
     }
       public function product(){
        return $this->belongsTo('App\Models\Product');
       }

       


}