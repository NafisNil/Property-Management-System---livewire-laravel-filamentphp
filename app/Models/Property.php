<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Support\Str;

class Property extends Model
{
    /** @use HasFactory<\Database\Factories\PropertyFactory> */
    use HasFactory;
    protected $fillable = ['title', 'description', 'type', 'status', 'listing_type', 'price', 'price_per_sqft', 'address', 'city', 'state', 'country', 'postal_code', 'latitude', 'longitude', 'bedrooms', 'bathrooms', 'area_sqft', 'year_built', 'has_garage', 'is_furnished', 'parking_spaces', 'features', 'images', 'slug', 'meta_title', 'meta_description', 'is_featured', 'is_active', 'featured_until', 'owner_name', 'owner_email', 'owner_phone'];

    protected $casts = [
        'features' => 'array',
        'images' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'has_garage' => 'boolean',
        'is_furnished' => 'boolean',
        'featured_until' => 'datetime',
        'price' => 'decimal:2',
        'price_per_sqft' => 'decimal:2',
        'latitude' => 'decimal:2',
        'longitude' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($property) {
            if (empty($property->slug)) {
                $property->slug = Str::slug($property->title) . '-' . uniqid();
            }
        });

        static::updating(function ($property) {
            if ($property->isDirty('title')) {
                $property->slug = Str::slug($property->title) . '-' . uniqid();
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    #[Scope]
    public function available(Builder $query)
    {
        return $query->where('is_active', true)->where('status', 'available');
    }
    #[Scope]
    public function forSale(Builder $query)
    {
        return $query->where('listing_type', 'sale');
    }

    #[Scope]
    public function forRent(Builder $query)
    {
        return $query->where('listing_type', 'rent');
    }

    #[Scope]
    public function featured(Builder $query)
    {
        return $query->where('is_featured', true)->where(function ($q) {
            $q->whereNull('featured_until')->orWhere('featured_until', '>=', now());
        });
    }

    #[Scope]
    public function inCity(Builder $query, $city)
    {
        return $query->where('city', 'like', '%' . $city . '%');
    }

    #[Scope]
    public function priceBetween(Builder $query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    #[Scope]
    public function byType(Builder $query, $type)
    {
        return $query->where('type', $type);
    }
    #[Scope]
    public function withBedrooms(Builder $query, int $bedrooms)
    {
        return $query->where('bedrooms', '>=', $bedrooms);
    }

    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }

    public function getFullAddressAttribute()
    {
        return "{$this->address}, {$this->city}, {$this->state}, {$this->country}, {$this->postal_code}";
    }

    public function getMainImageAttribute()
    {
        return $this->images[0] ?? null;
    }

    public function getImageUrlsAttribute()
    {
        return array_map(function ($image) {
            return asset('storage/properties/' . $image);
        }, $this->images ?? []);
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'available' => 'green',
            'sold' => 'red',
            'pending' => 'orange',
            'default' => 'gray',
            'rented' => 'blue',
            'draft' => 'gray',
        };
    }

    public function getTypeIconAttribute()
    {
        return match ($this->type) {
            'apartment' => 'fa-building',
            'house' => 'fa-home',
            'condo' => 'fa-city',
            'townhouse' => 'fa-house-user',
            'villa' => 'fa-vihara',
            'default' => 'fa-building',
        };
    }

    public function isFeatured(){
        return $this->is_featured && (is_null($this->featured_until) || $this->featured_until->isFuture());
    }

    public function isAvailable(){
        return $this->is_active && $this->status === 'available';
    }

    public function calculatePricePerSqft(){
        if($this->area_sqft > 0){
            return $this->price / $this->area_sqft;
        }
        return 0;
    }

    public function addFeature($feature){
        $features = $this->features ?? [];
        if(!in_array($feature, $features)){
            $features[] = $feature;
            $this->features = $features;
            $this->save();
        }
    }

    public function removeFeature($feature){
        $features = $this->features ?? [];
        if(in_array($feature, $features)){
            $features = array_filter($features, fn($f) => $f !== $feature);
            $this->features = array_values($features);
            $this->save();
        }
    }

    public function hasFeature($feature){
        $features = $this->features ?? [];
        return in_array($feature, $features);
    }

    public static function getPropertyTypes(){
        return ['apartment' => 'Apartment', 'house' => 'House', 'condo' => 'Condo', 'land' => 'Land', 'commercial' => 'Commercial', 'other' => 'Other'];
    }   

    public static function getListingTypes(){
        return ['sale' => 'For Sale', 'rent' => 'For Rent'];
    }

    public static function getStatuses(){
        return ['available' => 'Available', 'sold' => 'Sold', 'pending' => 'Pending', 'rented' => 'Rented', 'archived' => 'Archived'];
    }
}
