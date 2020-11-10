<?php

namespace Database\Factories;

use App\Models\Bus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bus::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $plate_number = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, 3) . ' ' . rand(100, 999);

        return [
            'plate_number' => $plate_number,
        ];
    }
}
