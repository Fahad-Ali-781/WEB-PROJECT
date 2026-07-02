<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id', 'name', 'slug', 'description', 'price', 'stock', 'image', 'city', 'is_featured'];

    public function scopeVisible($query)
    {
        return $query->whereHas('category', function ($categoryQuery) {
            $categoryQuery->whereNotIn('slug', ['gaming-disc', 'gaming-discs']);
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getAverageRatingAttribute(): float
    {
        return (float) ($this->reviews()->avg('rating') ?? 0);
    }

    public function getRatingCountAttribute(): int
    {
        return $this->reviews()->count();
    }
}
