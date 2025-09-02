<?php

namespace App\Domains\Presence\Models;

use App\Domains\Guests\Models\Guest;
use App\Domains\Guests\Models\GuestType;
use App\Domains\Presence\QueryBuilders\EventQueryBuilder;
use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property-read string $uuid
 * @property-read int $guest_type_id
 * @property string $name
 * @property string $location
 * @property Carbon $date
 * @property string $start
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read Carbon|null $deleted_at
 * @property-read GuestType $guestType
 * @property-read Collection<Guest>
 *
 * @method static EventFactory factory($count = null, $state = [])
 * @method static EventQueryBuilder query()
 */
class Event extends Model
{
    /** @use HasFactory<EventFactory> */
    use HasFactory;

    use HasUuids;
    use SoftDeletes;

    protected $fillable = ['guest_type_id', 'name', 'location', 'date', 'start'];

    /**
     * Get the columns that should receive a unique identifier.
     *
     * @return array<int, string>
     */
    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function guestType(): BelongsTo
    {
        return $this->belongsTo(GuestType::class);
    }

    public function guests(): BelongsToMany
    {
        return $this->belongsToMany(Guest::class, 'event_guest')
            ->withTimestamps();
    }

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'uuid' => 'string',
            'name' => 'string',
            'location' => 'string',
            'date' => 'date',
            'time' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    protected static function newFactory(): EventFactory
    {
        return EventFactory::new();
    }

    public function newEloquentBuilder($query): EventQueryBuilder
    {
        return new EventQueryBuilder($query);
    }
}
