<?php

namespace App\Domains\Guests\Models;

use App\Domains\Presence\Models\Event;
use Database\Factories\GuestTypeFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property-read string $uuid
 * @property string $name
 * @property string|null $description
 * @property string|null $present_text
 * @property string|null $absent_text
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read Carbon|null $deleted_at
 * @property-read Collection<Guest> $guests
 * @property-read Collection<Event> $events
 */
class GuestType extends Model
{
    /** @use HasFactory<\Database\Factories\GuestTypeFactory> */
    use HasFactory;

    use HasUuids;
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'present_text', 'absent_text'];

    /**
     * @return HasMany<Guest>
     */
    public function guests(): HasMany
    {
        return $this->hasMany(Guest::class);
    }

    public function availableGuests(): HasMany
    {
        return $this->guests()->whereDoesntHave('events');
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'name' => 'string',
            'description' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Get the columns that should receive a unique identifier.
     *
     * @return array<int, string>
     */
    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public static function newFactory(): GuestTypeFactory
    {
        return GuestTypeFactory::new();
    }
}
