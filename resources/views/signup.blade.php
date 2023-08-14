<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>BilliardPlayBook-SignUp</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />

    <!-- Background Image CSS -->
    <style>
        body {
            background-image: url('https://images5.alphacoders.com/107/1079250.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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
                    <li class="nav-item"><a class="nav-link" href="{{ url('/signup') }}">Sign Up</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/signin') }}">Sign In</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Signup Form Section -->
    <section class="pt-4">
        <div class="container px-lg-5">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card bg-light border-0 h-100">
                        <div class="card-body p-4 p-lg-5">
                            <h2 class="fs-4 fw-bold">Create An Account</h2>
                            <!-- Signup form -->
                            <form action="{{ url('/signup') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label text-end">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label text-end">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label text-end">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label text-end">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Sign Up</button>
                            </form>

@if ($errors->any())
    <div class="alert alert-danger mt-3">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <!-- Footer-->
    <footer class="py-3 bg-dark mt-auto">
        <div class="container">
            <p class="m-0 text-center text-white" style="font-size: 14px;">Copyright &copy; BilliardsPlayBook</p>
        </div>
    </footer>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>
</html>
