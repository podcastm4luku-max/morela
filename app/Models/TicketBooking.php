<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'destination_id',
        'visit_date',
        'visitor_name',
        'visitor_phone',
        'visitor_email',
        'visitor_city',
        'adult_count',
        'child_count',
        'price_per_ticket',
        'cleanliness_fee',
        'total_amount',
        'payment_method',
        'payment_status',
        'qr_validation_code',
        'paid_at',
        'checked_in_at',
    ];

    protected $casts = [
        'visit_date' => 'date',
        'paid_at' => 'datetime',
        'checked_in_at' => 'datetime',
        'total_amount' => 'integer',
        'adult_count' => 'integer',
        'child_count' => 'integer',
    ];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public static function generateBookingCode(): string
    {
        $date = now()->format('ymd');
        $random = rand(1000, 9999);

        return "MOR-{$date}-{$random}";
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp '.number_format($this->total_amount, 0, ',', '.');
    }
}
