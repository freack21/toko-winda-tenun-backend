<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductGallery extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'products_id', 'image'
    ];

    public function getUrlAttribute($url)
    {
        return config('app.image') . Storage::url($url);
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'products_id');
    }
}
