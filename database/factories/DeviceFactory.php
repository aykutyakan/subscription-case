<?php

namespace Database\Factories;

use App\Models\Device;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DeviceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Device::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $lang = ["tr", "fr", "ar", "en", "sp", "de", "it", "us"];
        $os = ["ios", "android"];
        $pass = ["password", "wrong-password"];
        return [
            "device_id" => $this->faker->uuid,
            "app_id" => $this->faker->ean8,
            "language" => $this->faker->randomElement($lang),
            "operating_system" => $this->faker->randomElement($os),
            "os_username"       => $this->faker->randomElement($os),
            "os_password"       => $this->faker->randomElement($pass),
            "client_token" => Str::random(25),
        ];
    }
}
