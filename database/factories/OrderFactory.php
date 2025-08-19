<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 3), //випадковий user_id
            'service_type' => $this->faker->randomElement(['repair', 'sewing', 'other']), // випадковий тип послуги
            'description' => $this->faker->sentence(), // випадковий опис
            'images' => json_encode([$this->faker->imageUrl(), $this->faker->imageUrl()]), // випадкові зображення
            'price' => $this->faker->numberBetween(50, 500), // Випадкова ціна
        ];
    }
}
