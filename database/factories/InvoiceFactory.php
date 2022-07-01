<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $status = $this->faker->randomElement(['B','P','V']);
        return [
            'customer_id' => Customer::factory(),
            'amount' => $this->faker->randomNumber(4),
            'status' => $status,
            'billed_date' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'paid_date' => $status == 'P' ? $this->faker->dateTimeBetween('-1 years', 'now') : null,
        ];
    }
}
