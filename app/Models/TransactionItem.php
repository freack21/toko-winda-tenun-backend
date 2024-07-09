<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id', 'products_id', 'transactions_id', 'quantity', 'variation_value_ids'
    ];

    protected $casts = [
        'variation_value_ids' => 'array',
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'products_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'users_id');
    }
    public function getVariationValuesAttribute()
    {
        return ProductVariationValue::whereIn('id', $this->variation_value_ids)->get();
    }
    public function getProductVariationValuesAttribute()
    {
        return $this->product()::with('variationValues')::whereIn('id', $this->variation_value_ids)->get();
    }
    public function getVariationStringAttribute()
    {
        $variationValues = $this->getVariationValuesAttribute();
        $values = $variationValues->pluck('value')->toArray();
        return implode(', ', $values);
    }
}
