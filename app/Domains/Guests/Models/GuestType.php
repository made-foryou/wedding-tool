<?php

namespace App\Domains\Guests\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property string $name
 * @property string|null $description
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read Carbon|null $deleted_at
 */
class GuestType extends Model
{
    use SoftDeletes;

    public $fillable = ['name', 'description'];

    public $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
}
