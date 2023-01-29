<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function booted()
    {
        // static::addGlobalScope('store', function (Builder $builder) {
        //     $user = Auth::user();
        //     if ($user->store_id) {
        //         $builder->where('store_id', '=', $user->store_id);
        //     }
        // });

        static::creating(function (Product $product) {
            $product->slug = Str::slug($product->name);
        });
    }
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $appends = ['image_url'];

    public function scopeActive(Builder $builder)
    {
        $builder->where('status', 'active');
    }
    public function Category()
    {
        return $this->belongsTo('App\Models\Category')->withDefault();
    }

    public function store()
    {
        return $this->belongsTo('App\Models\Store')->withDefault();
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class, //related model
            'product_tags' //bivot tableS
            // 'product_id', //fk in bivot table
            // 'tag_id', //fk in bivot table
            // 'id',
            // 'id'
        );
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'https://www.incathlab.com/images/products/default_product.png';
        }
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }

    public function getSalePercentAttribute()
    {
        if (!$this->compare_price) {
            return 0;
        }
        return 100 - (100 * $this->price) / $this->compare_price;
    }

    public function scopeFilter(Builder $builder, $filter)
    {
        $options = array_merge(
            [
                'store_id' => null,
                'category_id' => null,
                'tag_id' => null,
                'status' => 'active',
            ],
            $filter
        );

        $builder->when($options['store_id'], function ($builder, $value) {
            $builder->where('store_id', $value);
        });

        $builder->when($options['category_id'], function ($builder, $value) {
            $builder->where('category_id', $value);
        });

        $builder->when($options['tag_id'], function ($builder, $value) {
            $builder->whereHas('tags', function ($builder) use ($value) {
                $builder->where('id', $value);
            });
        });

        $builder->when($options['status'], function ($builder, $value) {
            $builder->where('status', $value);
        });
    }
}