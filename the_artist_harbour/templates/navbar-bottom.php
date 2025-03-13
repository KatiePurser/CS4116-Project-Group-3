<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyApp</title>

    <!-- Font we have chosen for design -->
    <link rel="stylesheet" href="css/styles.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <!-- Bootstrap JavaScript for interactive components-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



    <style>
        .navbar {
            padding: 15px;
            background-color: #82689A;
        }

        .nav-link {
            font-size: 1rem;
            font-weight: bold;
            color: white;
        }

        .nav-link:hover {
            color: #49375a;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: white;
        }

        .navbar-brand:hover {
            color: #49375a;
        }

        .search-bar {
            padding: 10px;
            max-width: 500px;
            /* Responsive */
            width: 100%;
        }

        .social-icon-group {
            color: #49375a;

        }
    </style>
</head>

<body>
    <!-- Mission Statement -->
    <div>

    </div>
    <!-- Defines a navigation bar makes navbar expland on large screens and collapse into hamburger on smaller screen -->
    <nav class="navbar navbar-expand-lg">
        <div class="container d-flex align-items-center justify-content-between">

            <ul class="d-flex navbar-nav">
                <li class="nav-item"><a class="nav-link fs-8 fs-md-5 fs-lg-4" href="about.php">About</a></li>
                <li class="nav-item"><a class="nav-link fs-8 fs-md-5 fs-lg-4" href="about.php">Contact Us</a></li>

            </ul>

            <div class="social-icon-group d-flex gap-3">
                <i class="bi bi-facebook fs-3 fs-md-4 fs-lg-5"></i>
                <i class="bi bi-instagram fs-3 fs-md-4 fs-lg-5"></i>
                <i class="bi bi-google fs-3 fs-md-4 fs-lg-5"></i>
                <i class="bi bi-twitter fs-3 fs-md-4 fs-lg-5"></i>
            </div>

        </div>
    </nav>

</body>

</html>