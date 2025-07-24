<?php

namespace App\Models;

use App\Domains\Guests\Models\Guest;
use App\Domains\Question\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    protected $primaryKey = null;
    public $incrementing = false;

    protected $table = 'guest_question_answers';

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
