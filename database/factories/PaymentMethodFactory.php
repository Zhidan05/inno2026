<?php

namespace Database\Factories;

use App\Enums\PaymentMethodType;
use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PaymentMethod>
 */
class PaymentMethodFactory extends Factory
{
    protected $model = PaymentMethod::class;

    public function definition(): array
    {
        return [
            'name' => 'Transfer Bank '.fake()->randomElement(['BCA', 'Mandiri', 'BRI', 'BNI']),
            'type' => PaymentMethodType::BANK_TRANSFER,
            'instructions' => fake()->sentence(),
            'is_active' => true,
            'sort_order' => fake()->numberBetween(1, 10),
            'bank_name' => fake()->randomElement(['BCA', 'Mandiri', 'BRI', 'BNI']),
            'account_number' => fake()->numerify('08##########'),
            'account_holder_name' => fake()->name(),
        ];
    }

    public function qris(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'QRIS '.fake()->words(2, true),
            'type' => PaymentMethodType::QRIS,
            'bank_name' => null,
            'account_number' => null,
            'account_holder_name' => null,
            'qris_image' => 'payment-methods/dummy.webp',
        ]);
    }
}
