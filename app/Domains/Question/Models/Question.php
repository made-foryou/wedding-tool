<?php

namespace App\Domains\Question\Models;

use App\Domains\Guests\Models\Guest;
use App\Domains\Guests\Models\GuestType;
use App\Domains\Presence\Models\Event;
use Database\Factories\QuestionFactory;
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
 * @property int $question_type_id
 * @property int|null $guest_type_id
 * @property int|null $event_id
 * @property string $label
 * @property string|null $description
 * @property array $data
 * @property int index
 * @property bool $is_hidden
 * @property bool $show_for_absent
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read Carbon|null $deleted_at
 *
 * @method static QuestionFactory factory($count = null, $state = [])
 */
class Question extends Model
{
    /** @use HasFactory<QuestionFactory> */
    use HasFactory;

    use HasUuids;
    use SoftDeletes;

    protected $fillable = [
        'question_type_id',
        'guest_type_id',
        'event_id',
        'label',
        'description',
        'data',
        'index',
        'is_hidden',
        'show_for_absent',
    ];

    protected $attributes = [
        'data' => '{}',
    ];

    public function questionType(): BelongsTo
    {
        return $this->belongsTo(QuestionType::class);
    }

    public function guestType(): BelongsTo
    {
        return $this->belongsTo(GuestType::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function guests(): BelongsToMany
    {
        return $this->belongsToMany(Guest::class, 'guest_question_answers', 'question_id', 'guest_id')
            ->withPivot('answer')
            ->withTimestamps();
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

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'question_type_id' => 'integer',
            'guest_type_id' => 'integer',
            'event_id' => 'integer',
            'label' => 'string',
            'description' => 'string',
            'data' => 'array',
            'index' => 'integer',
            'is_hidden' => 'boolean',
            'show_for_absent' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }
}
