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


                <div class="dropdown">
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

                    @endif

                </div>
            @endif

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

<!-- Rest of the page content... -->

<!-- Bootstrap core JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS -->
<script src="js/scripts.js"></script>
</body>
</html>
