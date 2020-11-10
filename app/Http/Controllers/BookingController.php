<?php

namespace App\Http\Controllers;

use App\Models\Seat;
use App\Models\Station;
use App\Models\Trip;
use Illuminate\Http\Request;
use App\Models\SeatAvailability;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\checkAvailableSeatRequest;
class BookingController extends Controller
{

    /**
     * check if there is available seat or not.
     *
     * @return
     */
    public function checkAvailableSeat(checkAvailableSeatRequest $request)
    {
        $start = $request->input('start');
        $end   = $request->input('end');

        $seat = $this->availableSeat($start, $end, 'check');

        return $seat ?
         Response::json(['result' => $seat, 'data' => 'Great!, There Are Seats Avaliable'])->setStatusCode(200, 'Success'):
         Response::json(['result' => $seat, 'data' => 'Unfortunately!, There Is No Seats Found'])->setStatusCode(400, 'fail');
    }

    /**
     * check available seat depend on $request.
     *
     * @return
     */
    public function availableSeat($start, $end, $requestType)
    {
        $tripPoints = $this->getTripPoints($start, $end);
        $seats = [];
        $availableSeats = [];
        $check = false;
        foreach ($tripPoints as $point){
             $trip = trip::find($point->trip_id);
             $seats = seat::where('bus_id', $trip->bus_id)->get()->pluck('id')->toArray();

             foreach ($seats as $seat){
                $check = $this->checkDuration($seat, $point->start , $point->end);

                if($requestType == 'check'){
                    if($check){
                        break;
                    }
                    return true;
                }
                else if($requestType == 'list'){
                    if($check){
                        array_push($availableSeats, $seat);
                    }
                }
            }
            if($requestType == 'list'){
                return $availableSeats;
            }
        }
        return $check;

    }

    /**
     * function to check if times occuped from point to point
     *
     * @param $seat
     * @param $start
     * @param $end
     * @return bool
     */
    public function checkDuration($seat, $start, $end){
        $available =  SeatAvailability::where('from_point_id', $start)->where('seat_id', $seat)->first();

       if($available){
           if($available->status == 0){
               if ($available->to_point_id == $end){

                   return true;
               }
              return $this->checkDuration($seat, $available->to_point_id, $end );
           }
           return false;
       }
       return false;

    }


    /**
     * get start and end stop point that has the same trip
     * @param $startStation
     * @param $endStation
     * @return mixed
     */
    public function getTripPoints($startStation, $endStation)
    {
        $start = Station::where('name', 'like', '%' . $startStation . '%')->first();
        $end = Station::where('name', 'like', '%' . $endStation . '%')->first();

       $trip_points =  \DB::table('trip_stop_points as tripPoints1')
        ->select("tripPoints1.id as start","tripPoints2.id as end","tripPoints2.trip_id")
            ->join('trip_stop_points as tripPoints2', function ($query){
                $query->on('tripPoints1.trip_id', '=',  'tripPoints2.trip_id')
                ->on('tripPoints1.route_order', '<','tripPoints2.route_order');
            })
            ->where('tripPoints1.station_id', $start->id)
            ->where('tripPoints2.station_id', $end->id)
           ->get();

       return $trip_points;

    }

    /**
     * list free seats.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return
     */
    public function listFreeSeats(Request $request)
    {
        $start = $request->input('start');
        $end   = $request->input('end');

        $availableSeats = $this->availableSeat($start, $end, 'list');

        return  (count($availableSeats) >= 1)?
          Response::json(['result' => 'OK', 'data' =>  $availableSeats ])->setStatusCode(200, 'Success')
           :Response::json('There Is No Seats available')->setStatusCode(400, 'fail');
    }

}
