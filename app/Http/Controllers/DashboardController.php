<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\GameRecord;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $userId = Auth::user()->id;
        $username = Auth::user()->name;
    
        // Check if the 'show_all' parameter is present in the query string
        $showAll = $request->query('show_all');
    
        // Fetch the selected game if specific opponent_name and game_date are provided
        $selectedGame = null;
        if (!$showAll) {
            $selectedOpponentData = $request->only(['opponent_name', 'game_date']);
            if (isset($selectedOpponentData['opponent_name']) && isset($selectedOpponentData['game_date'])) {
                $selectedGame = GameRecord::where('user_id', $userId)
                    ->where('opponent_name', $selectedOpponentData['opponent_name'])
                    ->where('game_date', $selectedOpponentData['game_date'])
                    ->first();
            }
        }
    
        // Fetch opponents data
        $query = GameRecord::where('user_id', $userId);
        $filterDate = $request->input('filter_date');
        if ($filterDate) {
            $query->whereDate('game_date', '<=', $filterDate);
        }
        $opponents = $query->get(['opponent_name', 'game_date'])
            ->unique(function ($item) {
                return $item['opponent_name'] . ' - ' . $item['game_date'];
            })
            ->values();
    
        // Fetch all game records if 'show_all' is true
        $allGameRecords = null;
        if ($showAll) {
            $allGameRecords = GameRecord::where('user_id', $userId)->get();
    
            // Manually render the view content with necessary data
            $viewContent = view('dashboard', compact('opponents', 'username', 'selectedGame', 'allGameRecords'))->render();
    
            // Return the view content
            return response($viewContent);
        }
    
        // Return the view without the allGameRecords data
        return view('dashboard', compact('opponents', 'username', 'selectedGame'));
    }
    

    public function downloadCSV($opponent_name, $game_date)
    {
        // Fetch the data for the selected game
        $userId = Auth::user()->id;
        $username = Auth::user()->name;
        $selectedGame = GameRecord::where('user_id', $userId)
            ->where('opponent_name', $opponent_name)
            ->where('game_date', $game_date)
            ->first();
    
        if (!$selectedGame) {
            return redirect()->route('dashboard')->with('error', 'Selected opponent data not found.');
        }
    
        // Fetch the same table data used to display the table
        $tableRows = []; // Get the data in the same format as used in the table
    
        // Initialize the CSV data with a header row
        $csvData = [
            ['Info', $username, $selectedGame->opponent_name,'Starting Scores',$selectedGame->starting_scores_player1,$selectedGame->starting_scores_player], // Add column names
        ];
    
        // ----------------------------------------
        // Create an array to store CSV data
        $csvData = [];

        // Add headers to the CSV data
        $csvData[] = [
            'Info',
            $username,
            $selectedGame->opponent_name
        ];

        // Define the column groups and their corresponding columns
        $columnGroups = [
            'Starting Scores' => [
                $selectedGame->starting_scores_player1,
                $selectedGame->starting_scores_player2
            ],
            'Ending Scores' => [
                $selectedGame->ending_scores_player1,
                $selectedGame->ending_scores_player2
            ],
            'Spot' => [
                $selectedGame->spot_player1,
                $selectedGame->spot_player2
            ],
            'Total Points'  => [
                $selectedGame->total_points_player1,
                $selectedGame->total_points_player2
            ],
            'Shots Taken' =>[
                $selectedGame->shots_taken_player1,
                $selectedGame->shots_taken_player2 

            ],
            'Shots Made' =>[
                $selectedGame->shots_made_player1,
                $selectedGame->shots_made_player2
            ],
            'Misses'=>[
                $selectedGame->misses_player1,
                $selectedGame->misses_player2
            ],
            'Good Misses'=>[
                $selectedGame->good_misses_player1,
                $selectedGame->good_misses_player2
            ],
            'Safeties'=>[
                $selectedGame->safeties_player1,
                $selectedGame->safeties_player2
            ],
            'Good Safeties'=>[
                $selectedGame->good_safeties_player1,
                $selectedGame->good_safeties_player2
            ],
            'Fouls'=>[
                $selectedGame->fouls_player1,
                $selectedGame->fouls_player2
            ],
            'Good Fouls'=>[
                $selectedGame->good_fouls_player1,
                $selectedGame->good_fouls_player2
            ],
            'Breaks'=>[
                $selectedGame->breaks_player1,
                $selectedGame->breaks_player2
            ],
            'Good Breaks'=>[
                $selectedGame->good_breaks_player1,
                $selectedGame->good_breaks_player2
            ],
            'High Run'=>[
                $selectedGame->high_run_player1,
                $selectedGame->high_run_player2
            ],
            'Average Run'=>[
                $selectedGame->average_run_player1,
                $selectedGame->average_run_player2
            ]
        ];
        // Loop through the column groups and create rows
        foreach ($columnGroups as $groupName => $columns) {
            $csvRow = [$groupName];

            foreach ($columns as $column) {
                $csvRow[] = $column;
            }

            // Add the row to CSV data
            $csvData[] = $csvRow;
        }
        
        // Create a temporary CSV file
        $tempFile = tempnam(sys_get_temp_dir(), 'csv');
        $csv = fopen($tempFile, 'w');
    
        // Write data to CSV
        foreach ($csvData as $csvRow) {
            fputcsv($csv, $csvRow);
        }
    
        fclose($csv);
    
        // Download the CSV file
        return response()->download($tempFile, 'game_data.csv', ['Content-Type' => 'text/csv']);
    }
    
    public function fetchGameRecords(Request $request)
    {
        $userId = Auth::user()->id;
        $gameRecords = GameRecord::where('user_id', $userId)->get();
        return response()->json($gameRecords);
    }
    


}



