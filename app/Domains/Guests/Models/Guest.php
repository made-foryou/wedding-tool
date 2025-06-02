<?php

namespace App\Domains\Guests\Models;

use Database\Factories\GuestFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property-read int $guest_type_id
 * @property string $first_name
 * @property string|null $last_name
 * @property string $email (Unique)
 * @property string|null $phone_number
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read Carbon $deleted_at
 *
 * @property-read GuestType $guestType
 */
class Guest extends Model
{
    use SoftDeletes;

    /** @use HasFactory<\Database\Factories\GuestFactory> */
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'email', 'phone_number'];

    /**
     * @return BelongsTo<GuestType>
     */
    public function guestType(): BelongsTo
    {
        return $this->belongsTo(GuestType::class);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'guest_type_id' => 'integer',
            'first_name' => 'string',
            'last_name' => 'string',
            'email' => 'string',
            'phone_number' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    public static function newFactory(): GuestFactory
    {
        return GuestFactory::new();
    }
}
