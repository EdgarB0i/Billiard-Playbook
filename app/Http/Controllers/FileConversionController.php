<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\GameRecord; 
use Illuminate\Support\Facades\Auth;


class FileConversionController extends Controller
{
    public function convert(Request $request)
    {
        $extension = $request->file('file')->extension();
        $fileName = 'to-be-converted-' . time() . '.' . $extension;

    
        $pdfPath = $request->file('file')->storeAs('uploads', $fileName);
    
        // Run the Python script
        $scriptPath = base_path('scripts/convert_pdf_to_csv.py');
        $command = 'python "' . $scriptPath . '" "' . $pdfPath . '"';
        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            Log::error("Python Script Output: " . implode(PHP_EOL, $output));
            $errorMessage = 'Please upload the correct pdf file of your pool match stats.';
            return view('welcome', compact('errorMessage'));
        }

        // Storing information for dashboard------------------------------------------------------------------------------------
        if (Auth::check()) {
            $csvFileName = str_replace('.pdf', '.csv', $fileName); // Replace the extension
            $csvFileName = str_replace('to-be-converted-', 'converted-', $csvFileName); // Replace "to-be-converted" with "converted"
            $csvFilePath = storage_path('app/uploads/' . $csvFileName);
    
            $data = []; // Initialize an empty array to store CSV data
    
            $handle = fopen($csvFilePath, 'r');
    
            if ($handle !== false) {
                $headers = fgetcsv($handle); // Read the headers
    
    
                while (($row = fgetcsv($handle)) !== false) {
                    // Store each row in the data array
                    $data[] = $row;
                }
    
                fclose($handle);
            }
    
            $loggedInUsername = Auth::user()->name; // Get the logged-in user's username
    
            if ($data[0][1] === $loggedInUsername || $data[0][2] === $loggedInUsername) {
                // Username matches with Player1
                if ($data[0][1] === $loggedInUsername) {
                    // Logged-in user is Player 1, update game_records table
                
                    $gameRecord = new GameRecord();
                    $gameRecord->user_id = Auth::user()->id;
                    $gameRecord->opponent_name = $data[0][2];
                    $gameRecord->game_date = date('Y-m-d', strtotime($data[0][3]));
                
                    $gameRecord->starting_scores_player1 = $data[1][1];
                    $gameRecord->ending_scores_player1 = $data[2][1];
                    $gameRecord->spot_player1 = $data[3][1];
                    $gameRecord->total_points_player1 = $data[4][1];
                    $gameRecord->shots_taken_player1 = $data[5][1];
                    $gameRecord->shots_made_player1 = $data[6][1];
                    $gameRecord->misses_player1 = $data[7][1];
                    $gameRecord->good_misses_player1 = $data[8][1];
                    $gameRecord->safeties_player1 = $data[9][1];
                    $gameRecord->good_safeties_player1 = $data[10][1];
                    $gameRecord->fouls_player1 = $data[11][1];
                    $gameRecord->good_fouls_player1 = $data[12][1];
                    $gameRecord->breaks_player1 = $data[13][1];
                    $gameRecord->good_breaks_player1 = $data[14][1];
                    $gameRecord->high_run_player1 = $data[15][1];
                    $gameRecord->average_run_player1 = $data[16][1];
                
                    $gameRecord->starting_scores_player2 = $data[1][2];
                    $gameRecord->ending_scores_player2 = $data[2][2];
                    $gameRecord->spot_player2 = $data[3][2];
                    $gameRecord->total_points_player2 = $data[4][2];
                    $gameRecord->shots_taken_player2 = $data[5][2];
                    $gameRecord->shots_made_player2 = $data[6][2];
                    $gameRecord->misses_player2 = $data[7][2];
                    $gameRecord->good_misses_player2 = $data[8][2];
                    $gameRecord->safeties_player2 = $data[9][2];
                    $gameRecord->good_safeties_player2 = $data[10][2];
                    $gameRecord->fouls_player2 = $data[11][2];
                    $gameRecord->good_fouls_player2 = $data[12][2];
                    $gameRecord->breaks_player2 = $data[13][2];
                    $gameRecord->good_breaks_player2 = $data[14][2];
                    $gameRecord->high_run_player2 = $data[15][2];
                    $gameRecord->average_run_player2 = $data[16][2];
                
                    $gameRecord->save();
                
            }else{
                    // Logged-in user is Player 2, update game_records table
                    $gameRecord = new GameRecord();
                    $gameRecord->user_id = Auth::user()->id;
                    $gameRecord->opponent_name = $data[0][1];
                    $gameRecord->game_date = date('Y-m-d', strtotime($data[0][3]));
                
                    $gameRecord->starting_scores_player1 = $data[1][2];
                    $gameRecord->ending_scores_player1 = $data[2][2];
                    $gameRecord->spot_player1 = $data[3][2];
                    $gameRecord->total_points_player1 = $data[4][2];
                    $gameRecord->shots_taken_player1 = $data[5][2];
                    $gameRecord->shots_made_player1 = $data[6][2];
                    $gameRecord->misses_player1 = $data[7][2];
                    $gameRecord->good_misses_player1 = $data[8][2];
                    $gameRecord->safeties_player1 = $data[9][2];
                    $gameRecord->good_safeties_player1 = $data[10][2];
                    $gameRecord->fouls_player1 = $data[11][2];
                    $gameRecord->good_fouls_player1 = $data[12][2];
                    $gameRecord->breaks_player1 = $data[13][2];
                    $gameRecord->good_breaks_player1 = $data[14][2];
                    $gameRecord->high_run_player1 = $data[15][2];
                    $gameRecord->average_run_player1 = $data[16][2];
                
                    $gameRecord->starting_scores_player2 = $data[1][1];
                    $gameRecord->ending_scores_player2 = $data[2][1];
                    $gameRecord->spot_player2 = $data[3][1];
                    $gameRecord->total_points_player2 = $data[4][1];
                    $gameRecord->shots_taken_player2 = $data[5][1];
                    $gameRecord->shots_made_player2 = $data[6][1];
                    $gameRecord->misses_player2 = $data[7][1];
                    $gameRecord->good_misses_player2 = $data[8][1];
                    $gameRecord->safeties_player2 = $data[9][1];
                    $gameRecord->good_safeties_player2 = $data[10][1];
                    $gameRecord->fouls_player2 = $data[11][1];
                    $gameRecord->good_fouls_player2 = $data[12][1];
                    $gameRecord->breaks_player2 = $data[13][1];
                    $gameRecord->good_breaks_player2 = $data[14][1];
                    $gameRecord->high_run_player2 = $data[15][1];
                    $gameRecord->average_run_player2 = $data[16][1];
                
                    $gameRecord->save();
            }
        }
            //------------------------------------------------------------------------------------------------------------------    
        }

        return redirect('/')->with([
            'success' => 'Your pdf files have been converted successfully.',
            'showPdfDownloadButton' => true,
        ]);
    }
    public function downloadLatestConvertedCSV()
    {
        // Find all "converted" CSV files
        $csvFiles = glob(storage_path('app/uploads/converted-*.csv'));
    
        if (empty($csvFiles)) {
            return response()->json(['error' => 'No converted CSV files found'], 404);
        }
    
        // Extract the numbers from the filenames and sort them in descending order
        $fileNumbers = [];
        foreach ($csvFiles as $csvFile) {
            $matches = [];
            if (preg_match('/converted-(\d+)\.csv/', $csvFile, $matches)) {
                $fileNumbers[] = intval($matches[1]);
            }
        }
        rsort($fileNumbers);
    
        // Get the latest converted CSV file based on the sorted numbers
        $latestCsv = storage_path('app/uploads/converted-' . $fileNumbers[0] . '.csv');
    
        // Get the file name without the full path
        $csvFileName = pathinfo($latestCsv, PATHINFO_BASENAME);
    
        // Download the latest converted CSV file
        return Response::download($latestCsv, $csvFileName);
    }
    
        
    
    
}
    
