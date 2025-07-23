<?php

namespace App\Domains\Guests\Models;

use App\Domains\Guests\QueryBuilder\GuestQueryBuilder;
use App\Domains\Presence\Models\Event;
use Database\Factories\GuestFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
 * @property-read string $name
 * @property string $first_name
 * @property string|null $last_name
 * @property string $email (Unique)
 * @property string|null $phone_number
 * @property bool $has_registered
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read Carbon $deleted_at
 * @property-read GuestType $guestType
 * @property-read Collection<Event> $events
 *
 * @method static GuestFactory factory($count = null, $state = [])
 * @method static GuestQueryBuilder query()
 */
class Guest extends Model
{
    /** @use HasFactory<GuestFactory> */
    use HasFactory;

    use HasUuids;
    use SoftDeletes;

    protected $fillable = ['guest_type_id', 'first_name', 'last_name', 'email', 'phone_number', 'has_registered'];

    public function name(): Attribute
    {
        return Attribute::make(
            get: function ($value, array $attributes): string {
                return "{$attributes['first_name']} {$attributes['last_name']}";
            },
        );
    }

    /**
     * @return BelongsTo<GuestType>
     */
    public function guestType(): BelongsTo
    {
        return $this->belongsTo(GuestType::class);
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_guest');
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
            'has_registered' => 'boolean',
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

    public static function newFactory(): GuestFactory
    {
        return GuestFactory::new();
    }

    public function newEloquentBuilder($query): GuestQueryBuilder
    {
        return new GuestQueryBuilder($query);
    }
}
