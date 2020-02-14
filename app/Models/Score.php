<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Game;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Score extends Model
{
    protected $table = 'scores';
    protected $primaryKey = 'id';
    protected $fillable = [
        'game_id', 'user_id', 'score','created_by','updated_by'
    ];
    protected $casts = [
        'game_id' => 'int',
        'user_id' => 'int',
        'score' => 'int',
    ];

    public function users():BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'id'
        );
    }

    public function games():BelongsTo
    {
        return $this->belongsTo(
            Game::class,
            'game_id',
            'id'
        );
    }

    public function game()
    {
        return $this->belongsTo('App\Models\Game');
    }
}
