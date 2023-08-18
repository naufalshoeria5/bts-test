<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Get the product that owns the ProductItem
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scope
    |--------------------------------------------------------------------------
    */

    /**
     * Scope Filter.
     *
     * @return void
     */
    public function scopeFilter($query, object $filter)
    {
        // if filter by product id exist
        $query->when($filter->product_id ?? false, fn ($query, $product_id) => $query->where('product_id', $product_id));

        // if filter by id exist
        $query->when($filter->id ?? false, fn ($query, $id) => $query->where('id', $id));
    }
}
