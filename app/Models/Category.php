<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug'
    ];

    /**
     * Get all products in this category
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Generate slug before saving
     */
 protected static function boot()
{
    parent::boot();

    static::creating(function ($category) {
        $category->slug = Str::slug($category->name);
    });

    static::updating(function ($category) {
        $category->slug = Str::slug($category->name);
    });
}
}