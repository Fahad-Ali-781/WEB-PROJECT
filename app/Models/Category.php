<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'image'];

    public function scopeVisible($query)
    {
        return $query->whereNotIn('slug', ['gaming-disc', 'gaming-discs']);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
