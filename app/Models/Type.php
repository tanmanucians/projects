<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Flashcard;

class Type extends Model
{
    protected $table = 'types';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name'
    ];

    /**
     * @return BelongsTo
     */
    public function flashcards(): BelongsTo
    {
        return $this->belongsTo(
            Flashcard::class,
            'flashcard_id',
            'id'
        );
    }
}
