<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'brand',
        'slug',
        'sku',
        'short_description',
        'description',
        'price',
        'compare_at_price',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'compare_at_price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function getFeaturedImageUrlAttribute(): string
    {
        $path = $this->images()
            ->orderBy('sort_order')
            ->value('path');

        if (! $path) {
            return 'https://via.placeholder.com/600x600?text=Nstore';
        }

        return Str::startsWith($path, ['http://', 'https://'])
            ? $path
            : Storage::url($path);
    }
}
