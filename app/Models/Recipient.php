<?php

namespace App\Models;

use App\Domains\Guests\Models\Guest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property int $email_id
 * @property int $guest_id
 * @property Carbon $sent_at
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 */
class Recipient extends Model
{
    protected $fillable = [
        'email_id',
        'guest_id',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function email(): BelongsTo
    {
        return $this->belongsTo(Email::class);
    }

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }
}
