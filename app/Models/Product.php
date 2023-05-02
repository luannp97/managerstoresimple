<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'status',
        'store_id',
        'import_price',
        'price',
        'product_code',
        'product_type',
        'sold',
        'total'
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
