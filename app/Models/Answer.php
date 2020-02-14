<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Answer extends Model
{
    protected $table = 'answers';
    protected $primaryKey = 'id';
    protected $fillable = [
        'flashcard_id', 'type_id', 'right_answer_option_id', 'created_by', 'updated_by'
    ];
    protected $casts = [
        'flashcard_id' => 'int',
        'type_id' => 'tinyint',
        'right_answer_option_id' => 'int'
    ];

    public function flashcards():BelongsTo
    {
        return $this->belongsTo(
            Flashcard::class,
            'flashcard_id',
            'id'
        );
    }

    public function answerOptions():HasMany
    {
        return $this->hasMany(
            AnswerOption::class,
            'right_answer_option_id',
            'id'
        );
    }
}
