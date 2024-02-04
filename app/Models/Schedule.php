<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;

    protected $table = "schedules";

    protected $primaryKey = "id";

    protected $fillable = [
        'user_id',
        'bus_id',
        'driver_id',
        'starting_point',
        'destination',
        'schedule_date',
        'departure_time',
        'estimated_arrival_time',
        'fare_amount',
        'remarks'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bus(): BelongsTo
    {
        return $this->belongsTo(Bus::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

}
