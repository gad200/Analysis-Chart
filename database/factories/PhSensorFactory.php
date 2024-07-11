<?php

namespace Database\Factories;

use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PhSensorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public $dates = array();
    public $start_date = '2024-04-01 12:00:00';
    public $end_date = '2024-04-07 12:00:00';
    public $interval_minutes = 30;

    public function __construct($count = null, ?Collection $states = null, ?Collection $has = null, ?Collection $for = null, ?Collection $afterMaking = null, ?Collection $afterCreating = null, $connection = null, ?Collection $recycle = null)
    {
        parent::__construct($count, $states, $has, $for, $afterMaking, $afterCreating, $connection, $recycle);
        $this->generateDates();
    }

    public function definition(): array
    {
        return [
            'location' => $this->faker->word,
            'data' => $this->faker->randomFloat(2, 0, 14),
            'sensor_type' => $this->faker->word,
            'created_at' => function() {
                if (empty($this->dates)) {
                    return null;
                }
                static $index = 0;
                return $this->dates[$index++ % count($this->dates)];
            },

        ];
    }

    function generateDates()
    {
        $current_date = new DateTime($this->start_date);
        $end_date = new DateTime($this->end_date);

        while ($current_date <= $end_date) {
            $this->dates[] = $current_date->format('Y-m-d H:i:s');
            $current_date->add(new DateInterval('PT' . $this->interval_minutes . 'M'));
        }

        return $this->dates;
    }
}
