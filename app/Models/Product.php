<?php

namespace App\Models;

use App\HasSlug;
use App\ProductInventory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str; // [+] TAMBAHKAN BARIS INI

class Product extends Model
{
    use HasFactory, HasSlug, ProductInventory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'sizes',
        'image',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'stock' => 'integer',
        'sizes' => 'array',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the order items for the product.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get primary image from image array.
     * * @return string|null
     */
    public function getPrimaryImage()
    {
        $imagePath = null;
        if (!empty($this->image)) {
            $imagePath = is_array($this->image) ? $this->image[0] : $this->image;
        }

        // Jika path adalah path file lokal, gunakan asset(). Jika base64, kembalikan langsung.
        if ($imagePath && !Str::startsWith($imagePath, 'data:image')) {
            return asset($imagePath);
        }

        // Return base64 string atau null jika tidak ada gambar
        return $imagePath;
    }

    /**
     * Get all images for the product.
     * * @return array
     */
    public function getAllImages()
    {
        $allImages = is_array($this->image) ? $this->image : [$this->image];

        return array_map(function ($imagePath) {
            if ($imagePath && !Str::startsWith($imagePath, 'data:image')) {
                return asset($imagePath);
            }
            return $imagePath;
        }, $allImages);
    }


    /**
     * Get the route key for the model.
     * * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include in-stock products.
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Scope a query to only include available products (active and in stock).
     */
    public function scopeAvailable($query)
    {
        return $query->active()->inStock();
    }

    /**
     * Format price to rupiah
     * * @return string
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Check if product has specific image
     * * @param string $imagePath
     * @return bool
     */
    public function hasImage(string $imagePath): bool
    {
        return in_array($imagePath, $this->getAllImages());
    }

    /**
     * Add new image to product
     * * @param string $imagePath
     * @return void
     */
    public function addImage(string $imagePath): void
    {
        $images = $this->getAllImages();
        $images[] = $imagePath;
        $this->image = array_unique($images);
        $this->save();
    }

    /**
     * Remove image from product
     * * @param string $imagePath
     * @return void
     */
    public function removeImage(string $imagePath): void
    {
        $images = $this->getAllImages();
        $this->image = array_values(array_diff($images, [$imagePath]));
        $this->save();
    }

    /**
     * Set primary image for product
     * * @param string $imagePath
     * @return void
     */
    public function setPrimaryImage(string $imagePath): void
    {
        if (!$this->hasImage($imagePath)) {
            return;
        }

        $images = $this->getAllImages();
        $key = array_search($imagePath, $images);
        unset($images[$key]);
        array_unshift($images, $imagePath);
        $this->image = array_values($images);
        $this->save();
    }
}
