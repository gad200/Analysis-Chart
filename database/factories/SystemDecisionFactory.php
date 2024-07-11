<?php

namespace Database\Factories;
use App\Models\PhSensor;
use App\Models\TempSensor;
use App\Models\SystemDecision;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SystemDecisionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ph_sensor_id' => rand(1, 10000),
            'temp_sensor_id' => rand(1, 10000),
        ];
    }
}
