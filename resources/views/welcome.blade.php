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
                    <li class="nav-item">
                        <form action="{{ route('signout') }}" method="GET">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link" style="cursor: pointer;">Sign Out</button>
                        </form>
                    </li>


                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ url('/signup') }}">Sign Up</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/signin') }}">Sign In</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>


    <!-- Header-->
    <header class="py-5">
        <div class="container px-lg-5">
            <div class="p-4 p-lg-5 bg-light rounded-3 text-center">
                <div class="m-4 m-lg-5">
                    <h1 class="display-5 fw-bold">Welcome to Billiards PlayBook!</h1>
                    <p class="fs-4">Your Ultimate Destination for Tracking, Analyzing, and Elevating Your Pool Games with pdf-to-csv conversion facilities.</p>
                    <!--<a class="btn btn-primary btn-lg" href="#!">Insert a PDF/ZIP file</a>-->
                    <!-- Add the file upload form -->
                    <form action="{{ route('convert') }}" method="POST" enctype="multipart/form-data" id="fileUploadForm" style="display: none;">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Upload PDF or ZIP File:</label>
                            <input type="file" class="form-control" id="file" name="file" accept=".pdf, .zip">
                        </div>
                        <button type="submit" class="btn btn-primary">Convert to CSV</button>
                    </form>

                    <!-- Add the button to trigger file input -->
                    <a class="btn btn-primary btn-lg" href="#" id="triggerFileUpload">Insert a PDF or ZIP file</a>  
                    @if(session('success') && session('showZipDownloadButton'))
                        <a class="btn btn-success btn-lg" href="{{ route('download-converted-zip') }}">Download</a>
                    @endif

                    @if(session('success') && session('showPdfDownloadButton'))
                        <a class="btn btn-success btn-lg" href="{{ route('download-latest-converted-csv') }}">Download</a>
                    @endif

                    
                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            const triggerButton = document.getElementById('triggerFileUpload');
                            const fileUploadForm = document.getElementById('fileUploadForm');
                            const fileInput = document.getElementById('file');

                            triggerButton.addEventListener('click', function () {
                                fileInput.click();
                            });

                            fileInput.addEventListener('change', function () {
                                // Determine the selected file's extension
                                const selectedFile = this.files[0];
                                if (selectedFile) {
                                    const fileExtension = selectedFile.name.split('.').pop().toLowerCase();
                                    if (fileExtension === 'zip') {
                                        // Set the form action to the 'convertzip' route for ZIP files
                                        fileUploadForm.action = "{{ route('convertzip') }}";
                                    } else {
                                        // Set the form action to the 'convert' route for PDF files
                                        fileUploadForm.action = "{{ route('convert') }}";
                                    }
                                }
                                fileUploadForm.submit();
                            });
                        });
                    </script>





                </div>
            </div>
        </div>
    </header>
    <!-- Page Content-->
    <section class="pt-4 content">
        <div class="container px-lg-5">
            <!-- Page Features-->
            <div class="row gx-lg-5">
                <div class="col-lg-6 col-xxl-4 mb-5">
                    <div class="card bg-light border-0 h-100">
                        <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4"><i class="bi bi-collection"></i></div>
                            <h2 class="fs-4 fw-bold">Upload multiple PDFs</h2>
                            <p class="mb-0">Convert multiple pdf files by uploading them in a zip file. </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xxl-4 mb-5">
                    <div class="card bg-light border-0 h-100">
                        <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4"><i class="bi bi-cloud-download"></i></div>
                            <h2 class="fs-4 fw-bold">Download Your Stats</h2>
                            <p class="mb-0">You can download your stats of various matches.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xxl-4 mb-5">
                    <div class="card bg-light border-0 h-100">
                        <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4"><i class="bi bi-card-heading"></i></div>
                            <h2 class="fs-4 fw-bold">Stats Dashboard</h2>
                            <p class="mb-0">Check out your detailed stats in different games on the website itself!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>





<!-- Success Toast Message -->
<div class="row justify-content-center">
    <div class="col-md-6">
        @if(session('success'))
            <div class="alert alert-success mt-3 text-center" id="successMessage">
                {{ session('success') }}
            </div>
        @endif
    </div>
</div>



    <!-- Error toast -->
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(isset($errorMessage))
                <div class="alert alert-danger text-center" role="alert">
                    {{ $errorMessage }}
                </div>
            @endif

            <!-- Your existing form and content here -->
        </div>
    </div>
</div>


<!-- Your existing form and content here -->

    <!-- Footer -->
    <footer class="py-3 bg-dark mt-auto">
        <div class="container">
            <p class="m-0 text-center text-white" style="font-size: 14px;">Copyright &copy; BilliardsPlayBook</p>
        </div>
    </footer>

    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS -->
    <script src="js/scripts.js"></script>
<!-- success message script handling -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const successMessage = document.getElementById('successMessage');
            
            if (successMessage) {
                // Set the timeout to hide the success message after 5 seconds (5000 milliseconds)
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 3000); // Adjust the time interval as needed
            }
        });
    </script>




</body>
</html>
