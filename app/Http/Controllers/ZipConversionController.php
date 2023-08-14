<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\GameRecord; 
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use ZipArchive;

class ZipConversionController extends Controller
{
    public function convert(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:zip',
        ]);

        // Store the uploaded ZIP file with a unique filename
        $extension = $request->file('file')->getClientOriginalExtension();
        $fileName = 'to-be-converted-' . time() . '.' . $extension;
        $zipPath = $request->file('file')->storeAs('uploads', $fileName);

        // Extract the ZIP contents to a unique folder
        $extractedFolderPath = $this->extractZipContents($zipPath);
        

        // Run the Python script and generate CSV files
        $scriptPath = base_path('scripts/convert_zip_to_csv.py');
        $command = 'python "' . $scriptPath . '" "' . $extractedFolderPath . '"';
        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            $errorMessage = 'Please upload the correct zip file of your pool match stats.';
            return view('welcome', compact('errorMessage'));
        }
        if (Auth::check()) {
            // Storing information for dashboard------------------------------------------------------------------------------------
            $csvFolderName = str_replace('.zip','', $fileName); // Replace the extension
            $csvFilePath = storage_path('app/uploads/' . $csvFolderName);
            $csvFiles = glob($csvFilePath . '/*.csv');
            $loggedInUsername = Auth::user()->name;
            foreach ($csvFiles as $csvFilePath) {
                $data = []; // Initialize an empty array to store CSV data
                $handle = fopen($csvFilePath, 'r');
                if ($handle !== false) {
                    while (($row = fgetcsv($handle)) !== false) {
                        // Store each row in the data array
                        $data[] = $row;
                    }
                    fclose($handle);
                }          
                if ($data[1][1] === $loggedInUsername || $data[1][2] === $loggedInUsername) {
                    if ($data[1][1] === $loggedInUsername) {
                        // Logged-in user is Player 1, update game_records table
                        $gameRecord = new GameRecord();
                        $gameRecord->user_id = Auth::user()->id;
                        $gameRecord->opponent_name = $data[1][2];
                        $gameRecord->game_date = date('Y-m-d', strtotime($data[1][3]));
                        
                        $gameRecord->starting_scores_player1 = $data[2][1];
                        $gameRecord->ending_scores_player1 = $data[3][1];
                        $gameRecord->spot_player1 = $data[4][1];
                        $gameRecord->total_points_player1 = $data[5][1];
                        $gameRecord->shots_taken_player1 = $data[6][1];
                        $gameRecord->shots_made_player1 = $data[7][1];
                        $gameRecord->misses_player1 = $data[8][1];
                        $gameRecord->good_misses_player1 = $data[9][1];
                        $gameRecord->safeties_player1 = $data[10][1];
                        $gameRecord->good_safeties_player1 = $data[11][1];
                        $gameRecord->fouls_player1 = $data[12][1];
                        $gameRecord->good_fouls_player1 = $data[13][1];
                        $gameRecord->breaks_player1 = $data[14][1];
                        $gameRecord->good_breaks_player1 = $data[15][1];
                        $gameRecord->high_run_player1 = $data[16][1];
                        $gameRecord->average_run_player1 = $data[17][1];
                    
                        $gameRecord->starting_scores_player2 = $data[2][2];
                        $gameRecord->ending_scores_player2 = $data[3][2];
                        $gameRecord->spot_player2 = $data[4][2];
                        $gameRecord->total_points_player2 = $data[5][2];
                        $gameRecord->shots_taken_player2 = $data[6][2];
                        $gameRecord->shots_made_player2 = $data[7][2];
                        $gameRecord->misses_player2 = $data[8][2];
                        $gameRecord->good_misses_player2 = $data[9][2];
                        $gameRecord->safeties_player2 = $data[10][2];
                        $gameRecord->good_safeties_player2 = $data[11][2];
                        $gameRecord->fouls_player2 = $data[12][2];
                        $gameRecord->good_fouls_player2 = $data[13][2];
                        $gameRecord->breaks_player2 = $data[14][2];
                        $gameRecord->good_breaks_player2 = $data[15][2];
                        $gameRecord->high_run_player2 = $data[16][2];
                        $gameRecord->average_run_player2 = $data[17][2];
                    
                        $gameRecord->save();
                    
                }else{
                        // Logged-in user is Player 2, update game_records table
                        $gameRecord = new GameRecord();
                        $gameRecord->user_id = Auth::user()->id;
                        $gameRecord->opponent_name = $data[1][1];
                        $gameRecord->game_date = date('Y-m-d', strtotime($data[1][3]));
                    
                        $gameRecord->starting_scores_player1 = $data[2][2];
                        $gameRecord->ending_scores_player1 = $data[3][2];
                        $gameRecord->spot_player1 = $data[4][2];
                        $gameRecord->total_points_player1 = $data[5][2];
                        $gameRecord->shots_taken_player1 = $data[6][2];
                        $gameRecord->shots_made_player1 = $data[7][2];
                        $gameRecord->misses_player1 = $data[8][2];
                        $gameRecord->good_misses_player1 = $data[9][2];
                        $gameRecord->safeties_player1 = $data[10][2];
                        $gameRecord->good_safeties_player1 = $data[11][2];
                        $gameRecord->fouls_player1 = $data[12][2];
                        $gameRecord->good_fouls_player1 = $data[13][2];
                        $gameRecord->breaks_player1 = $data[14][2];
                        $gameRecord->good_breaks_player1 = $data[15][2];
                        $gameRecord->high_run_player1 = $data[16][2];
                        $gameRecord->average_run_player1 = $data[17][2];
                    
                        $gameRecord->starting_scores_player2 = $data[2][1];
                        $gameRecord->ending_scores_player2 = $data[3][1];
                        $gameRecord->spot_player2 = $data[4][1];
                        $gameRecord->total_points_player2 = $data[5][1];
                        $gameRecord->shots_taken_player2 = $data[6][1];
                        $gameRecord->shots_made_player2 = $data[7][1];
                        $gameRecord->misses_player2 = $data[8][1];
                        $gameRecord->good_misses_player2 = $data[9][1];
                        $gameRecord->safeties_player2 = $data[10][1];
                        $gameRecord->good_safeties_player2 = $data[11][1];
                        $gameRecord->fouls_player2 = $data[12][1];
                        $gameRecord->good_fouls_player2 = $data[13][1];
                        $gameRecord->breaks_player2 = $data[14][1];
                        $gameRecord->good_breaks_player2 = $data[15][1];
                        $gameRecord->high_run_player2 = $data[16][1];
                        $gameRecord->average_run_player2 = $data[17][1];
                    
                        $gameRecord->save();
                }
                }
            }
            //-------------------------------------------------------------------------------------------------------------------

        }
        // Archive the generated CSV files and create a zip archive
        $this->archiveCsvFiles($extractedFolderPath);
        
        return redirect('/')->with([
            'success' => 'Your zip file has been uploaded successfully.',
            'showZipDownloadButton' => true,
        ]);  
    }

    private function extractZipContents($zipPath)
    {
        // Extract the ZIP contents to a unique folder
        $extractedFolderPath = Storage::path('uploads/' . pathinfo($zipPath, PATHINFO_FILENAME));

        // Create the folder if it doesn't exist
        if (!file_exists($extractedFolderPath)) {
            mkdir($extractedFolderPath, 0777, true);
        }

        // Extract the ZIP contents
        $zip = new ZipArchive();
        if ($zip->open(Storage::path($zipPath)) === true) {
            $zip->extractTo($extractedFolderPath);
            $zip->close();
        }

        return $extractedFolderPath;
    }

    private function archiveCsvFiles($folderPath)
    {
        // Get a list of generated CSV files
        $csvFiles = glob($folderPath . '/*.csv');

        // Archive the CSV files and create a zip archive
        $zip = new ZipArchive();
        $zipFileName = 'converted_csv_files.zip';
        $zipFilePath = $folderPath . '/' . $zipFileName;

        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($csvFiles as $csvFile) {
                $csvFileName = basename($csvFile);
                $zip->addFile($csvFile, $csvFileName);
            }
            $zip->close();
        }
    }

    public function downloadConvertedZip()
    {
        $parentDir = storage_path('app/uploads');
        
        $toBeConvertedFolders = [];
        $pattern = '/^to-be-converted-(\d+)$/';
        foreach (scandir($parentDir) as $folder) {
            if (preg_match($pattern, $folder)) {
                $toBeConvertedFolders[] = $folder;
            }
        }
    
        $hasPdfFiles = false;
        
        if (empty($toBeConvertedFolders)) {
            $errorMessage = 'Please upload a proper zip file with PDF files.';
            return view('welcome', compact('errorMessage'));
        }
        
    
        rsort($toBeConvertedFolders);
        $latestFolder = $toBeConvertedFolders[0];
        
        $zipFilePath = storage_path("app/uploads/{$latestFolder}/converted_csv_files.zip");
    
        if (file_exists($zipFilePath)) {
            return response()->download($zipFilePath, 'converted_csv_files.zip')->deleteFileAfterSend();
        } else {
            $errorMessage = 'Wrong Zip file uploaded. Please upload a zip file with proper pdf(s) of your game records.';
            return view('welcome', compact('errorMessage'));
        }
    }
    
    

}
