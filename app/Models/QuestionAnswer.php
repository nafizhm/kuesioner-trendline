<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['suggestion_id', 'question_id', 'answer_text'])]
class QuestionAnswer extends Model
{
    public function suggestion(): BelongsTo
    {
        return $this->belongsTo(Suggestion::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
