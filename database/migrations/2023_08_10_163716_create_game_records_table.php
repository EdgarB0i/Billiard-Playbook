<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign key for the user who uploaded the game
            $table->string('opponent_name'); // Name of the opponent player
            $table->date('game_date');

            // stats for Player 1
            $table->integer('starting_scores_player1');
            $table->integer('ending_scores_player1');
            $table->integer('spot_player1');
            $table->integer('total_points_player1');
            $table->integer('shots_taken_player1');
            $table->string('shots_made_player1');
            $table->string('misses_player1');
            $table->string('good_misses_player1');
            $table->string('safeties_player1');
            $table->string('good_safeties_player1');
            $table->string('fouls_player1');
            $table->string('good_fouls_player1');
            $table->integer('breaks_player1');
            $table->string('good_breaks_player1');
            $table->integer('high_run_player1');
            $table->float('average_run_player1');
            
            //stats for player2
            $table->integer('starting_scores_player2');
            $table->integer('ending_scores_player2');
            $table->integer('spot_player2');
            $table->integer('total_points_player2');
            $table->integer('shots_taken_player2');
            $table->string('shots_made_player2');
            $table->string('misses_player2');
            $table->string('good_misses_player2');
            $table->string('safeties_player2');
            $table->string('good_safeties_player2');
            $table->string('fouls_player2');
            $table->string('good_fouls_player2');
            $table->integer('breaks_player2');
            $table->string('good_breaks_player2');
            $table->integer('high_run_player2');
            $table->float('average_run_player2');
           

            $table->timestamps();

            // Define foreign key relationship
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_records');
    }
}
