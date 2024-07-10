<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'description', 'price', 'categories_id', 'tags'
    ];

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function galleries()
    {
        return $this->hasMany(ProductGallery::class, 'products_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'categories_id', 'id');
    }

    public function variations()
    {
        return $this->hasMany(ProductVariationValue::class, 'product_id')->with('option');
    }

    public function variationOptions()
    {
        return $this->belongsToMany(ProductVariationOption::class, 'product_variation_values', 'product_id', 'option_id')
            ->withPivot('value')
            ->withTimestamps();
    }
}
