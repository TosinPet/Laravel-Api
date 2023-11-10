<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    protected $date;
    protected $address;
    protected $subtotal;
    protected $total_amount;


    public function definition(): array
    {
        return [
            //
            'email' => $this->faker->email,
            'phone' => $this->faker->phone,
            'order_number' => $this->faker->slug,
            'order_date' => $this->date,
            'shipping_address' => $this->address,
            'subtotal' => $this->subtotal,
            'total_amount' => $this->total_amount,
        ];
    }
}
