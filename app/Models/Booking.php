<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $table = "bookings";

    protected $primaryKey = "id";

    protected $fillable = [
        'user_id',
        'customer_id',
        'schedule_id',
        'number_of_seats',
        'fare_amount',
        'total_amount',
        'date_of_booking',
        'booking_status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

}
