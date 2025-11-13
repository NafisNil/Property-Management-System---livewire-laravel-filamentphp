<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(array_keys(\App\Models\Property::getPropertyTypes()));
        $listingType = $this->faker->randomElement(array_keys(\App\Models\Property::getListingTypes()));
        $status = $this->faker->randomElement(array_keys(\App\Models\Property::getStatuses()));
        $basePrice = $listingType === 'sale' ? $this->faker->numberBetween(50000, 1000000) : $this->faker->numberBetween(1000, 5000);
        $price = $type === 'land' ? $basePrice * 0.8 : $basePrice;
        $title = $type === 'land' ? $this->faker->words(3, true) . ' Land' : $this->faker->words(3, true) . ' ' . ucfirst($type);
        return [
            'title' => $title,
            'description' => $this->faker->paragraph(),
            'type' => $type,
            'status' => $status,
            'listing_type' => $listingType,
            'price' => $price,
            'price_per_sqft' => $type === 'land' ? null : $price / $this->faker->numberBetween(100, 500),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'country' => $this->faker->country(),
            'postal_code' => $this->faker->postcode(),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'bedrooms' => $this->faker->numberBetween(1, 5),
            'bathrooms' => $this->faker->numberBetween(1, 5),
            'area_sqft' => $this->faker->numberBetween(500, 5000),
            'year_built' => $this->faker->year(),
            'has_garage' => $this->faker->boolean(),
            'is_furnished' => $this->faker->boolean(),
            'parking_spaces' => $this->faker->numberBetween(1, 3),
            'features' => $this->faker->words(3, true),
            'images' => [
                $this->faker->imageUrl(),
                $this->faker->imageUrl(),
                $this->faker->imageUrl(),
            ],
            'slug' => Str::slug($title) . '-' . uniqid(),
            'meta_title' => $this->faker->sentence(),
            'meta_description' => $this->faker->paragraph(),
            'is_featured' => $this->faker->boolean(),
            'is_active' => $this->faker->boolean(),
            'featured_until' => $this->faker->dateTimeBetween('now', '+1 year'),
            'owner_name' => $this->faker->name(),
            'owner_email' => $this->faker->email(),
            'owner_phone' => $this->faker->phoneNumber(),
        ];
    }
}
