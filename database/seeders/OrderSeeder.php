<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // Очищення таблиці перед заповненням
        Order::truncate();

        // Дані для заповнення
        $data = [
            [
                'user_id' => 1, // Прив'язка до користувача з ID 1
                'service_type' => 'repair',
                'description' => 'Repairing a sewing machine',
                'images' => json_encode(['orders/image1.jpg', 'orders/image2.jpg']),
                'price' => 100,
            ],
            [
                'user_id' => 1,
                'service_type' => 'sewing',
                'description' => 'Custom sewing project',
                'images' => json_encode(['orders/image3.jpg']),
                'price' => 200,
            ],
            [
                'user_id' => 2,
                'service_type' => 'other',
                'description' => 'Consultation for sewing techniques',
                'images' => json_encode([]),
                'price' => 50,
            ],
        ];

        // Створення записів у таблиці
        foreach ($data as $order) {
            Order::create($order);
        }

        // Генерація додаткових записів через фабрику
        Order::factory(50)->create();
    }
}
