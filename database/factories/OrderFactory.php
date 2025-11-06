<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = ['pending', 'processing', 'completed', 'cancelled'];
        $paymentMethods = ['cod', 'transfer'];

        return [
            'user_id' => User::factory(),
            'order_number' => strtoupper(Str::random(10)),
            'customer_name' => $this->faker->name,
            'customer_email' => $this->faker->unique()->safeEmail,
            'customer_phone' => $this->faker->phoneNumber,
            'shipping_address' => $this->faker->address,
            'status' => $this->faker->randomElement($statuses),
            'payment_method' => $this->faker->randomElement($paymentMethods),
            'payment_status' => $this->faker->randomElement(['unpaid', 'paid', 'refunded']),
            'subtotal' => 0,
            'shipping_cost' => $this->faker->randomFloat(2, 0, 50000),
            'total' => 0,
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
