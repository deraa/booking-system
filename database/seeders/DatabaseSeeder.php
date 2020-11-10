<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\Seat;
use App\Models\SeatAvailability;
use App\Models\Station;
use App\Models\Trip;
use App\Models\TripStopPoint;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * @var $stations
     */
    protected $stations;

    /**
     * @var $trip
     */
    protected $trip;

    /**
     * @var $bus
     */
    protected $bus;

    /**
     * @var $all_seats
     */
    protected $all_seats = [];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      $this->createStations();
      $this->createBus();
      $this->createTripStopPoints();
      $this->createSeatAvailability();
    }

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function createStations()
    {
        $data = [
            ['name' => 'Cairo'],
            ['name' => 'Giza'],
            ['name' => 'AlFayyum'],
            ['name' => 'AlMinya'],
            ['name' => 'Asyut'],
            ['name' => 'Aswan'],
        ];

        if(Station::count() == 0){
          $this->stations =   Station::insert($data);
        }

    }
    /**
     * create bus and trip and bus's seats.
     *
     * @return void
     */
    public function createBus()
    {
        $this->bus =   Bus::factory()
            ->has(Seat::factory()->count(12), 'seats')
            ->create();

        $this->trip = Trip::factory()->create(['bus_id' =>  $this->bus->id]);
    }

    /**
     * create trip and stop point.
     *
     * @return void
     */
    public function createTripStopPoints()
    {
        $trip_points = [
            [
                'trip_id' => $this->trip->id,
                'station_id' => Station::where('name', 'Cairo')->get()->first()->id,
                'route_order' => 1
            ],
            [
                'trip_id' => $this->trip->id,
                'station_id' => Station::where('name', 'AlFayyum')->get()->first()->id,
                'route_order' => 2
            ],
            [
                'trip_id' => $this->trip->id,
                'station_id' => Station::where('name', 'AlMinya')->get()->first()->id,
                'route_order' => 3
            ],
            [
                'trip_id' => $this->trip->id,
                'station_id' => Station::where('name', 'Asyut')->get()->first()->id,
                'route_order' => 4
            ],

        ];
        if(TripStopPoint::count() == 0){
            TripStopPoint::insert($trip_points);
        }
    }

    /**
     * create trip and stop point.
     *
     * @return void
     */
    public function createSeatAvailability()
    {
        $seats = Seat::where('bus_id', $this->bus->id)->get();

        $available_durations = [
            [
                'from_point_id' => 1,
                'to_point_id' => 2,
                'status' => 0
            ],
            [
                'from_point_id' => 2,
                'to_point_id' => 3,
                'status' => 0
            ],
            [
                'from_point_id' => 3,
                'to_point_id' => 4,
                'status' => 0
            ]
        ];

        $available_durations = collect($seats)->map(function ($seat) use ($available_durations){

            return collect($available_durations)->map(function ($duration) use ($seat){
                $duration['seat_id'] = $seat->id;
                return $duration;
            });
        });

        if(SeatAvailability::count() == 0){
            foreach ($available_durations->toArray() as $duration){
                SeatAvailability::insert($duration);
            }
        }
    }
}

