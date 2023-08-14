<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'opponent_name',
        'game_date',
        'starting_scores_player1',
        'ending_scores_player1',
        'spot_player1',
        'total_points_player1',
        'shots_taken_player1',
        'shots_made_player1',
        'misses_player1',
        'good_misses_player1',
        'safeties_player1',
        'good_safeties_player1',
        'fouls_player1',
        'good_fouls_player1',
        'breaks_player1',
        'good_breaks_player1',
        'high_run_player1',
        'average_run_player1',
        'starting_scores_player2',
        'ending_scores_player2',
        'spot_player2',
        'total_points_player2',
        'shots_taken_player2',
        'shots_made_player2',
        'misses_player2',
        'good_misses_player2',
        'safeties_player2',
        'good_safeties_player2',
        'fouls_player2',
        'good_fouls_player2',
        'breaks_player2',
        'good_breaks_player2',
        'high_run_player2',
        'average_run_player2',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
