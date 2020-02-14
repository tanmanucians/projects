<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Game extends Model
{
    protected $table = 'games';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name','created_by','updated_by'
    ];
    protected $casts = [
        'name' => 'string'
    ];
    public function flashcards()
    {
        return $this->belongsToMany('App\Models\Flashcard' , 'game_flashcards');
    }

    public function scores()
    {
        return $this->hasMany('App\Models\Score');
    }
    
    public function getImageAttribute()
    {
        $flashCard= $this->flashcards()->where('upload_path','!=',null);
        if ($flashCard->first()) { 
             return asset('/images/'.$flashCard->first()->upload_path);
        } else return null;
    }
    public function getMaxScoreAttribute()
    {
        $score = $this->scores->max('score');
        return $score;
    }
    public function getTotalAttribute()
    {
        $total = $this->flashcards->count();
        return $total;
    }
    public function getFlashcardIdsAttribute()
    {
        //$listId = $this->flashcards->all();
        $listId = $this->flashcards->pluck('id');
        return $listId;
    }
    
}
