<?php

namespace App\Models;

use Database\Factories\QuestionTypeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property string $name
 * @property string | null $description
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read Carbon | null $deleted_at
 */
class QuestionType extends Model
{
    /** @use HasFactory<QuestionTypeFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * @return string[]
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
}
