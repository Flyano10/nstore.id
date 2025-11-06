<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as FakerFactory;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = FakerFactory::create('id_ID');

        if (Product::count() === 0) {
            $this->call(ProductSeeder::class);
        }

        $users = User::query()->count() >= 3
            ? User::inRandomOrder()->take(3)->get()
            : User::factory(3)->create();

        $products = Product::with('sizes')->get();

        if ($products->isEmpty()) {
            return;
        }

        foreach (range(1, 5) as $index) {
            $user = $users->random();
            $items = $products->random(rand(2, 3));

            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => $faker->phoneNumber(),
                'shipping_address' => $faker->address(),
                'status' => $faker->randomElement(['pending', 'processing', 'completed']),
                'payment_method' => $faker->randomElement(['cod', 'transfer']),
                'payment_status' => $faker->randomElement(['unpaid', 'paid']),
                'subtotal' => 0,
                'shipping_cost' => 0,
                'total' => 0,
                'notes' => $faker->optional()->sentence(),
            ]);

            $subtotal = 0;

            foreach ($items as $product) {
                $size = $product->sizes->isNotEmpty()
                    ? $product->sizes->random()
                    : null;

                $quantity = rand(1, 2);
                $price = $product->price;
                $lineTotal = $price * $quantity;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_size_id' => $size?->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'product_size' => $size?->size,
                    'quantity' => $quantity,
                    'price' => $price,
                    'total' => $lineTotal,
                ]);

                $subtotal += $lineTotal;
            }

            $shipping = $faker->boolean ? 30000 : 0;

            $order->update([
                'subtotal' => $subtotal,
                'shipping_cost' => $shipping,
                'total' => $subtotal + $shipping,
            ]);
        }
    }
}
