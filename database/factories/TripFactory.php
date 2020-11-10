<?php

namespace Database\Factories;

use App\Models\Bus;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Factories\Factory;

class TripFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Trip::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'bus_id' => Bus::factory()->create()->id,
            'start_time' => $this->faker->dateTime(),
            'arrival_time' => $this->faker->dateTime(),
        ];
    }
}
