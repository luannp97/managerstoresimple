<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'is_active',
        'status',
        'author_id',
        'image',
        'store_code',
        'type_of',
        'total_monthly_cost',
        'total_cost_per_year',
        'total_monthly_revenue',
        'total_annual_revenue'
    ];

    public function products():HasMany {
        return $this->hasMany(Product::class);
    }

    public function user():BelongsTo {
        return $this->belongsTo(User::class);
    }
}
