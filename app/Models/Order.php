<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'resi', 'sender_name', 'sender_phone', 'sender_address',
        'sender_province', 'sender_city', 'sender_district', 'sender_village', 'sender_postal_code',
        'receiver_name', 'receiver_phone', 'receiver_address',
        'receiver_province', 'receiver_city', 'receiver_district', 'receiver_village', 'receiver_postal_code',
        'weight', 'length', 'width', 'height', 'reff_no', 'koli',
        'price_per_kg', 'total_shipping',
        'payment_method', 'payment_status', 'billing_notes',
        'current_status',
        'pod_photo', 'pod_signature', 'pod_receiver_name',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
    ];

    public function trackingLogs(): HasMany
    {
        return $this->hasMany(TrackingLog::class);
    }

    public static function generateResi(): string
    {
        do {
            $resi = 'JP' . mt_rand(1000000000, 9999999999);
        } while (self::where('resi', $resi)->exists());
        return $resi;
    }
}
