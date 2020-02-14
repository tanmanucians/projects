<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameFlashcard extends Model
{
    protected $table = 'game_flashcards';
    protected $primaryKey = 'id';
    protected $fillable = [
        'flashcard_id','game_id','created_by','updated_by'
    ];
    protected $casts = [
        'flashcard_id' => 'int',
        'game_id' => 'int',
    ];
}
