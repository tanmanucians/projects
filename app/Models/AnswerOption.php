<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnswerOption extends Model
{
    protected $table = 'answer_options';
    protected $primaryKey = 'id';
    protected $fillable = [
        'flashcard_id', 'value', 'created_by', 'updated_by'
    ];
    protected $casts = [
        'flashcard_id' => 'int',
        'value' => 'text'
    ];

    public function flashcard()
    {
        return $this->belongsTo('App\Models\Flashcard');
    }
}
