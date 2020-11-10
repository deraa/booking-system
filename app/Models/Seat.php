<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bus_id',
    ];

    /**
     * Get the bus that belong to the trip.
     */
    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }
}
