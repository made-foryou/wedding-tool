<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property string $subject
 * @property string $content
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read Carbon|null $deleted_at
 *
 * @property-read Collection<Recipient> $recipients
 */
class Email extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'subject',
        'content',
    ];

    public function recipients(): HasMany
    {
        return $this->hasMany(Recipient::class);
    }

    protected function casts(): array
    {
        return [
            'subject' => 'string',
            'content' => 'string',
        ];
    }
}
