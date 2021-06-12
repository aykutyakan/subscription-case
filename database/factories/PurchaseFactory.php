<?php

namespace Database\Factories;

use App\Models\Device;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Purchase::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $devices = $this->randomDevice();
        return [
            "device_app_id" => $this->faker->unique->randomElement($devices)->id,
            "reciept" => $this->faker->unique()->ean13,
            "expire_date" => $this->faker->dateTimeBetween("-10 weeks", "+10 weeks"),
            "is_active" => $this->faker->randomElement([true, false]),
        ];
    }

    private function randomDevice()
    {
        return Device::all();
    }
}
