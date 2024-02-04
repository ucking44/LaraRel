<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $table = "customers";

    protected $primaryKey = "id";

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_contact',
        'customer_email',
        'username',
        'password',
        'account_status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function booking(): HasOne
    {
        return $this->hasOne(Booking::class);
    }

}
