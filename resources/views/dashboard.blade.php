<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>BilliardPlayBook</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />

    <!-- Background Image CSS -->
    <style>
        body {
            background-image: url('https://cdn.wallpapersafari.com/32/31/A0jMOv.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        /* Add this style for sticky footer */
        .content {
            flex: 1;
        }
        .game-table th,
        .game-table td {
            white-space: nowrap; /* Prevent text from wrapping */
            overflow: hidden; /* Hide overflowing text */
            text-overflow: ellipsis; /* Show ellipsis for overflow */
        }
    
        .table-header {
            font-size: 24px;
            margin-top: 20px;
        }

    </style>

</head>

<body>
<!-- Responsive navbar-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-lg-5">
    <a class="navbar-brand" href="{{ url('/') }}" style="pointer-events: none;">Billiards PlayBook</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{ url('/') }}">Home</a></li>
                @if(Auth::check())
                    <li class="nav-item"><a class="nav-link" href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="nav-item">
                        <form action="{{ route('signout') }}" method="GET">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link" style="cursor: pointer;">Sign Out</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ url('/signup') }}">Sign Up</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/signin') }}">Sign In</a></li>
                @endif

            </ul>
        </div>
    </div>
</nav>

<!-- Header -->
<header class="py-5">
    <div class="container px-lg-5">
        <div class="p-4 p-lg-5 bg-light rounded-3 text-center">
            <div class="m-4 m-lg-5">
                <h1 class="display-6 fw-bold">Welcome back, {{ $username }}!</h1>
                <p class="fs-5">You can check your previous match records here.</p>

                <button class="btn btn-secondary btn-sm float-right mb-2" data-bs-toggle="modal" data-bs-target="#filterModal">
                    Filter by Date
                </button>


                <div class="d-flex justify-content-center align-items-center" style="margin-bottom: 15px;">
                    <div class="dropdown mr-2">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="opponentDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Select Opponent
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="opponentDropdown">
                            @foreach ($opponents as $opponent)
                                <li>
                                    <a class="dropdown-item" href="#" data-game="{{ json_encode(['opponent_name' => $opponent['opponent_name'], 'game_date' => $opponent['game_date']]) }}" onclick="selectOpponent(this)">
                                        {{ $opponent['opponent_name'] }} - {{ date('Y-m-d', strtotime($opponent['game_date'])) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div style="margin-left: 10px;">
                        <button class="btn btn-danger" onclick="redirectToCustomURL()">Show All Game Records</button>
                    </div>


                </div>

                <div id="allGameRecords" class="mt-5">
                    <!-- Placeholder for displaying all game records -->
                </div>
                @if(isset($selectedGame))
            <div class="container mt-5">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Info</th>
                                <th>{{ $username }}</th>
                                <th>{{ $selectedGame->opponent_name }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Starting Scores</th>
                                <td>{{ $selectedGame->starting_scores_player1 }}</td>
                                <td>{{ $selectedGame->starting_scores_player2 }}</td>
                            </tr>
                            <tr>
                                <th>Ending Scores</th>
                                <td>{{ $selectedGame->ending_scores_player1 }}</td>
                                <td>{{ $selectedGame->ending_scores_player2 }}</td>
                            </tr>
                            <tr>
                                <th>Spot</th>
                                <td>{{ $selectedGame->spot_player1 }}</td>
                                <td>{{ $selectedGame->spot_player2 }}</td>
                            </tr>
                            <tr>
                                <th>Total Points</th>
                                <td>{{ $selectedGame->total_points_player1 }}</td>
                                <td>{{ $selectedGame->total_points_player2 }}</td>
                            </tr>
                            <tr>
                                <th>Shots Taken</th>
                                <td>{{ $selectedGame->shots_taken_player1 }}</td>
                                <td>{{ $selectedGame->shots_taken_player2 }}</td>
                            </tr>
                            <tr>
                                <th>Shots Made</th>
                                <td>{{ $selectedGame->shots_made_player1 }}</td>
                                <td>{{ $selectedGame->shots_made_player2 }}</td>
                            </tr>
                            <tr>
                                <th>Misses</th>
                                <td>{{ $selectedGame->misses_player1 }}</td>
                                <td>{{ $selectedGame->misses_player2 }}</td>
                            </tr>
                            <tr>
                                <th>Good Misses</th>
                                <td>{{ $selectedGame->good_misses_player1 }}</td>
                                <td>{{ $selectedGame->good_misses_player2 }}</td>
                            </tr>
                            <tr>
                                <th>Safeties</th>
                                <td>{{ $selectedGame->safeties_player1 }}</td>
                                <td>{{ $selectedGame->safeties_player2 }}</td>
                            </tr>
                            <tr>
                                <th>Good Safeties</th>
                                <td>{{ $selectedGame->good_safeties_player1 }}</td>
                                <td>{{ $selectedGame->good_safeties_player2 }}</td>
                            </tr>
                            <tr>
                                <th>Fouls</th>
                                <td>{{ $selectedGame->fouls_player1 }}</td>
                                <td>{{ $selectedGame->fouls_player2 }}</td>
                            </tr>
                            <tr>
                                <th>Good Fouls</th>
                                <td>{{ $selectedGame->good_fouls_player1 }}</td>
                                <td>{{ $selectedGame->good_fouls_player2 }}</td>
                            </tr>
                            <tr>
                                <th>Breaks</th>
                                <td>{{ $selectedGame->breaks_player1 }}</td>
                                <td>{{ $selectedGame->breaks_player2 }}</td>
                            </tr>
                            <tr>
                                <th>Good Breaks</th>
                                <td>{{ $selectedGame->good_breaks_player1 }}</td>
                                <td>{{ $selectedGame->good_breaks_player2 }}</td>
                            </tr>
                            <tr>
                                <th>High Run</th>
                                <td>{{ $selectedGame->high_run_player1 }}</td>
                                <td>{{ $selectedGame->high_run_player2 }}</td>
                            </tr>
                            <tr>
                                <th>Average Run</th>
                                <td>{{ $selectedGame->average_run_player1 }}</td>
                                <td>{{ $selectedGame->average_run_player2 }}</td>
                            </tr>
                        </tbody>
                    </table>
                    @if(isset($selectedGame))
                    <div class="text-center">
                        <a href="{{ route('downloadCSV', ['opponent_name' => $selectedGame->opponent_name, 'game_date' => $selectedGame->game_date]) }}" class="btn btn-success mt-3">
                            Download as CSV
                        </a>
                    </div>
                    <br>
                    @endif

                </div>
            @endif
            <div class="text-center">
            <button id="downloadCSVButton" class="btn btn-primary" style="display: none; margin: 0 auto;" onclick="downloadAllGameRecords()">Download CSV</button>
            </div>

            </div>
        </div>
    </div>
</header>
<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="filterModalLabel">Filter by Date</h5>
            <button type="button" class="btn btn-close" style="color: #98FB98;" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

            <div class="modal-body">
                <form action="{{ route('dashboard') }}" method="GET">
                    <div class="mb-3">
                        <label for="filter_date" class="form-label">Game records within this date will be shown:</label>
                        <input type="date" name="filter_date" id="filter_date" class="form-control" value="{{ request('filter_date') }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Apply Filter</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function selectOpponent(anchor) {
        const gameData = JSON.parse(anchor.getAttribute('data-game'));
        const url = "{{ route('dashboard') }}";
        const opponentName = encodeURIComponent(gameData.opponent_name);
        const gameDate = encodeURIComponent(gameData.game_date);

        // Modify the current URL to include opponent_name and game_date as query parameters
        const newUrl = `${url}?opponent_name=${opponentName}&game_date=${gameDate}`;
        
        // Redirect to the modified URL
        window.location.href = newUrl;
    }
</script>

<script>
let createdTables = [];
// Define the custom URL outside the function
const baseUrl = window.location.origin + window.location.pathname;
const customURL = `${baseUrl}?show_all=true`;

function showAllGameRecords() {
    const allGameRecordsDiv = document.getElementById('allGameRecords');
    allGameRecordsDiv.innerHTML = ''; // Clear any previous content

    // Get the filter date from the URL parameters
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const filterDate = urlParams.get('filter_date');
    console.log("filter:", filterDate);

    // Array to store td values
    const tdValuesArray = [];

    // Make an AJAX request to fetch game records
    fetch("{{ route('fetchGameRecords') }}")
        .then(response => response.json())
        .then(data => {
            // Push td values to the array
            data.forEach(gameData => {
                const tdValues = {
                    opponent_name: gameData.opponent_name,
                    game_date: gameData.game_date,

                    starting_scores_player1: gameData.starting_scores_player1,
                    starting_scores_player2: gameData.starting_scores_player2,

                    ending_scores_player1: gameData.ending_scores_player1,
                    ending_scores_player2: gameData.ending_scores_player2,

                    spot_player1: gameData.spot_player1,
                    spot_player2: gameData.spot_player2,

                    total_points_player1: gameData.total_points_player1,
                    total_points_player2: gameData.total_points_player2,

                    shots_taken_player1: gameData.shots_taken_player1,
                    shots_taken_player2: gameData.shots_taken_player2,

                    shots_made_player1: gameData.shots_made_player1,
                    shots_made_player2: gameData.shots_made_player2,

                    misses_player1: gameData.misses_player1,
                    misses_player2: gameData.misses_player2,
                    
                    good_misses_player1: gameData.good_misses_player1,
                    good_misses_player2: gameData.good_misses_player2,

                    safeties_player1: gameData.safeties_player1,
                    safeties_player2: gameData.safeties_player2,

                    good_safeties_player1: gameData.good_safeties_player1,
                    good_safeties_player2: gameData.good_safeties_player2,

                    fouls_player1: gameData.fouls_player1,
                    fouls_player2: gameData.fouls_player2,

                    good_fouls_player1: gameData.good_fouls_player1,
                    good_fouls_player2: gameData.good_fouls_player2,

                    breaks_player1: gameData.breaks_player1,
                    breaks_player2: gameData.breaks_player2,

                    good_breaks_player1: gameData.good_breaks_player1,
                    good_breaks_player2: gameData.good_breaks_player2,

                    high_run_player1: gameData.high_run_player1,
                    high_run_player2: gameData.high_run_player2,

                    average_run_player1: gameData.average_run_player1,
                    average_run_player2: gameData.average_run_player2,
                };
                tdValuesArray.push(tdValues);
            });
            let uniqueTdValuesArray = tdValuesArray.filter(
                (value, index, self) =>
                    index === self.findIndex(v => JSON.stringify(v) === JSON.stringify(value))
            );

            // Filter out duplicates from tdValuesArray
            uniqueTdValuesArray = tdValuesArray.filter(
                (value, index, self) =>
                    index === self.findIndex(v => JSON.stringify(v) === JSON.stringify(value))
            );
            

            // Apply the filter on uniqueTdValuesArray based on filterDate
            for (let i = uniqueTdValuesArray.length - 1; i >= 0; i--) {
                if (filterDate && uniqueTdValuesArray[i].game_date > filterDate) {
                    uniqueTdValuesArray.splice(i, 1);
                }
            }

            const groupedTdValues = {};
            uniqueTdValuesArray.forEach(tdValues => {
                const opponentName = tdValues.opponent_name;
                if (!groupedTdValues[opponentName]) {
                    groupedTdValues[opponentName] = [];
                }
                groupedTdValues[opponentName].push(tdValues);
            });

            const averagedTdValuesArray = [];
            Object.keys(groupedTdValues).forEach(opponentName => {
                const group = groupedTdValues[opponentName];

                const averageTdValues = {
                    opponent_name: opponentName,
                    game_date: group[0].game_date, // Assuming game_date is the same for all in a group

                    starting_scores_player1: calculateAverage(group, 'starting_scores_player1'),
                    starting_scores_player2: calculateAverage(group, 'starting_scores_player2'),

                    ending_scores_player1: calculateAverage(group, 'ending_scores_player1'),
                    ending_scores_player2: calculateAverage(group, 'ending_scores_player2'),

                    spot_player1: calculateAverage(group, 'spot_player1'),
                    spot_player2: calculateAverage(group, 'spot_player2'),

                    total_points_player1: calculateAverage(group, 'total_points_player1'),
                    total_points_player2: calculateAverage(group, 'total_points_player2'),

                    shots_taken_player1: calculateAverage(group, 'shots_taken_player1'),
                    shots_taken_player2: calculateAverage(group, 'shots_taken_player2'),

                    shots_made_player1: calculateAverage(group, 'shots_made_player1'),
                    shots_made_player2: calculateAverage(group, 'shots_made_player2'),

                    misses_player1: calculateAverage(group, 'misses_player1'),
                    misses_player2: calculateAverage(group, 'misses_player2'),

                    good_misses_player1: calculateAverage(group,'good_misses_player1'),
                    good_misses_player2: calculateAverage(group, 'good_misses_player2'),

                    safeties_player1: calculateAverage(group,'safeties_player1'),
                    safeties_player2: calculateAverage(group,'safeties_player2'),

                    good_safeties_player1: calculateAverage(group, 'good_safeties_player1'),
                    good_safeties_player2: calculateAverage(group, 'good_safeties_player2'),

                    fouls_player1: calculateAverage(group, 'fouls_player1'),
                    fouls_player2: calculateAverage(group, 'fouls_player2'),

                    good_fouls_player1: calculateAverage(group, 'good_fouls_player1'),
                    good_fouls_player2: calculateAverage(group, 'good_fouls_player2'),

                    breaks_player1: calculateAverage(group, 'breaks_player1'),
                    breaks_player2: calculateAverage(group, 'breaks_player2'),
                    
                    good_breaks_player1: calculateAverage(group, 'good_breaks_player1'),
                    good_breaks_player2: calculateAverage(group, 'good_breaks_player2'),
                    
                    high_run_player1: calculateAverage(group, 'high_run_player1'),
                    high_run_player2: calculateAverage(group, 'high_run_player2'),

                    average_run_player1: calculateAverage(group, 'average_run_player1'),
                    average_run_player2: calculateAverage(group, 'average_run_player2'),
                };

                averagedTdValuesArray.push(averageTdValues);
            });

                // Function to calculate the average of a specific attribute
                function calculateAverage(group, attribute) {
                    const sum = group.reduce((acc, tdValues) => {
                        const value = tdValues[attribute];
                        
                        // Check if the value is in the format x (y%)
                        if (typeof value === 'string' && value.includes('(') && value.includes('%)')) {
                            const parts = value.split(' '); // Split by space to separate x and (y%)
                            const numericalValue = parseFloat(parts[0]);
                            const percentageValue = parseFloat(parts[1].replace('(', '').replace('%)', ''));
                            return {
                                sum: acc.sum + numericalValue,
                                count: acc.count + 1,
                                percentageSum: acc.percentageSum + percentageValue
                            };
                        } else {
                            const numericalValue = parseFloat(value);
                            return {
                                sum: acc.sum + numericalValue,
                                count: acc.count + 1,
                                percentageSum: acc.percentageSum // No percentage value to consider
                            };
                        }
                    }, { sum: 0, count: 0, percentageSum: 0 });

                    const average = (sum.sum / sum.count).toFixed(2);
                    
                    // Conditionally append the percentage part only if percentageSum is nonzero
                    const percentageAverage = sum.percentageSum !== 0
                        ? `(${(sum.percentageSum / sum.count).toFixed(2)}%)`
                        : '';

                    // Convert the average to a number if there's no percentage part
                    return percentageAverage
                        ? `${average} ${percentageAverage}`
                        : parseFloat(average);
                }

                // Find opponent_names that have a match in averagedTdValuesArray
                const matchingOpponents = new Set(uniqueTdValuesArray.map(item => item.opponent_name).filter(name => averagedTdValuesArray.some(avgItem => avgItem.opponent_name === name)));

                // Replace matching opponents in uniqueTdValuesArray with their corresponding averagedTdValuesArray item
                matchingOpponents.forEach(opponent => {
                    const averagedMatch = averagedTdValuesArray.find(avgItem => avgItem.opponent_name === opponent);

                    if (averagedMatch) {
                        uniqueTdValuesArray = uniqueTdValuesArray.filter(item => item.opponent_name !== opponent);
                        uniqueTdValuesArray.push(averagedMatch);
                    }
                });





            console.log("Averageee",averagedTdValuesArray);
            console.log('uniqueeee',uniqueTdValuesArray);
            uniqueTdValuesArray.forEach((uniqueTdValues, index) => {
                // Check if filterDate is provided and game_date is before or equal to filterDate
                if (!filterDate || uniqueTdValues.game_date <= filterDate) {
                    // Create a new container for each opponent's game records
                    const container = document.createElement('div');
                    container.className = 'game-record-container';

                    // Create a table header for each table
                    const tableHeader = document.createElement('h2');
                    tableHeader.textContent = `Opponent - ${index + 1}`;
                    tableHeader.className = 'table-header';

                    // Create a new table for each opponent's game records
                    const table = document.createElement('table');
                    table.className = 'table game-table';

                    // Construct the table content
                    const tableContent = `
                        <thead>
                            <tr>
                                <th>Info</th>
                                <th>{{ $username }}</th>
                                <th>${uniqueTdValues.opponent_name}</th>
                            </tr>
                        </thead>
                        <tbody>
                                <!-- ... Rows for other game data ... -->
                                <tr>
                                        <th>Starting Scores</th>
                                        <td>${uniqueTdValues.starting_scores_player1}</td>
                                        <td>${uniqueTdValues.starting_scores_player2}</td>
                                    </tr>
                                    <tr>
                                        <th>Ending Scores</th>
                                        <td>${uniqueTdValues.ending_scores_player1}</td>
                                        <td>${uniqueTdValues.ending_scores_player2}</td>
                                    </tr>
                                    <tr>
                                        <th>Spot</th>
                                        <td>${uniqueTdValues.spot_player1}</td>
                                        <td>${uniqueTdValues.spot_player2}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Points</th>
                                        <td>${uniqueTdValues.total_points_player1 }</td>
                                        <td>${uniqueTdValues.total_points_player2 }</td>
                                    </tr>
                                    <tr>
                                        <th>Shots Taken</th>
                                        <td>${uniqueTdValues.shots_taken_player1 }</td>
                                        <td>${uniqueTdValues.shots_taken_player2 }</td>
                                    </tr>
                                    <tr>
                                        <th>Shots Made</th>
                                        <td>${uniqueTdValues.shots_made_player1 }</td>
                                        <td>${uniqueTdValues.shots_made_player2 }</td>
                                    </tr>
                                    <tr>
                                        <th>Misses</th>
                                        <td>${uniqueTdValues.misses_player1 }</td>
                                        <td>${uniqueTdValues.misses_player2 }</td>
                                    </tr>
                                    <tr>
                                        <th>Good Misses</th>
                                        <td>${uniqueTdValues.good_misses_player1 }</td>
                                        <td>${uniqueTdValues.good_misses_player2 }</td>
                                    </tr>
                                    <tr>
                                        <th>Safeties</th>
                                        <td>${uniqueTdValues.safeties_player1 }</td>
                                        <td>${uniqueTdValues.safeties_player2 }</td>
                                    </tr>
                                    <tr>
                                        <th>Good Safeties</th>
                                        <td>${uniqueTdValues.good_safeties_player1 }</td>
                                        <td>${uniqueTdValues.good_safeties_player2 }</td>
                                    </tr>
                                    <tr>
                                        <th>Fouls</th>
                                        <td>${uniqueTdValues.fouls_player1 }</td>
                                        <td>${uniqueTdValues.fouls_player2 }</td>
                                    </tr>
                                    <tr>
                                        <th>Good Fouls</th>
                                        <td>${uniqueTdValues.good_fouls_player1 }</td>
                                        <td>${uniqueTdValues.good_fouls_player2 }</td>
                                    </tr>
                                    <tr>
                                        <th>Breaks</th>
                                        <td>${uniqueTdValues.breaks_player1 }</td>
                                        <td>${uniqueTdValues.breaks_player2 }</td>
                                    </tr>
                                    <tr>
                                        <th>Good Breaks</th>
                                        <td>${uniqueTdValues.good_breaks_player1 }</td>
                                        <td>${uniqueTdValues.good_breaks_player2 }</td>
                                    </tr>
                                    <tr>
                                        <th>High Run</th>
                                        <td>${uniqueTdValues.high_run_player1 }</td>
                                        <td>${uniqueTdValues.high_run_player2 }</td>
                                    </tr>
                                    <tr>
                                        <th>Average Run</th>
                                        <td>${uniqueTdValues.average_run_player1 }</td>
                                        <td>${uniqueTdValues.average_run_player2 }</td>
                                    </tr>                            
                            </tbody>
                    `;
                    table.innerHTML = tableContent;

                    // Append the table header and table to the container
                    container.appendChild(tableHeader);
                    container.appendChild(table);

                    // Append the container to the allGameRecordsDiv
                    allGameRecordsDiv.appendChild(container);
                }
            });
        
                // Show the "Download CSV" button and apply the text-center class
                const downloadCSVButton = document.getElementById('downloadCSVButton');
                const downloadButtonContainer = document.querySelector('.text-center');
                downloadCSVButton.style.display = 'block';
                downloadButtonContainer.classList.add('text-center');
                
            })
            .catch(error => {
                console.error("Error fetching game records:", error);
            });

    }

    function redirectToCustomURL() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const filterDate = urlParams.get('filter_date');
        
        // Append the filter_date parameter to the custom URL only if it's not null
        const newCustomURL = filterDate !== null ? `${customURL}&filter_date=${filterDate}` : customURL;

        window.location.href = newCustomURL;
    }

        window.onload = () => {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const showAll = urlParams.get('show_all');

        if (showAll === 'true') {
            // Load all game records without filtering
            showAllGameRecords();
        }
    };

</script>

<script>
    function downloadAllGameRecords() {
        const allTables = document.querySelectorAll('.game-table'); // Get all tables
        let csvContent = 'data:text/csv;charset=utf-8,';

        allTables.forEach((table, index) => {
            const tableNumber = index + 1;
            const infoCellValue = `Table - ${tableNumber}`;
            let isFirstRow = true; // Flag to skip "Table - No." in subsequent rows;

            const rows = table.querySelectorAll('tbody tr'); // Get rows of each table
            rows.forEach(row => {
                const rowHeader = row.querySelector('th').textContent; // Get row header
                const columns = row.querySelectorAll('td'); // Get columns of each row
                const rowValues = Array.from(columns).map(column => column.textContent);

                if (isFirstRow) {
                    csvContent += 'Info,' + '{{ $username }}' + ',' + table.querySelector('thead th:last-child').textContent + '\r\n';
                    csvContent +=rowHeader + ',' + rowValues.join(',') + '\r\n';
                    isFirstRow = false;
                } else {
                    csvContent +=rowHeader + ',' + rowValues.join(',') + '\r\n';
                }
            });

            csvContent += '\r\n'; // Add empty line between tables
        });

        const encodedUri = encodeURI(csvContent);
        const link = document.createElement('a');
        link.setAttribute('href', encodedUri);
        link.setAttribute('download', 'game_records.csv');
        document.body.appendChild(link);
        link.click();
    }
</script>



<!-- Bootstrap core JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS -->
<script src="js/scripts.js"></script>
</body>
</html>
