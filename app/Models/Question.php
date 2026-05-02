<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['question_text', 'placeholder', 'sort_order', 'is_active'])]
class Question extends Model
{
    use HasFactory;

    public function answers(): HasMany
    {
        return $this->hasMany(QuestionAnswer::class);
    }
}
