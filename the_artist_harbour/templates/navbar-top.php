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
            background-color: #82689A;
            position: fixed;

        }

        .nav-link {
            font-size: 1rem;
            font-weight: bold;
            color: white;
        }

        .nav-link:hover {
            color: #49375a !important;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: white !important;
        }

        .navbar-brand:hover {
            color: #49375a !important;
        }

        .search-bar {
            padding: 10px;
            max-width: 500px;
            width: 100%;
        }
    </style>
</head>

<body>
    <!-- Defines a navigation bar makes navbar expland on large screens and collapse into hamburger on smaller screen -->
    <nav class="navbar navbar-expand-lg">
        <div class="container d-flex align-items-center justify-content-between">

            <!-- Logo, Brand Name & Toggle Button in One Row -->
            <div class="d-flex align-items-center flex-grow-1">
                <img src="assets/images/boat_logo_small.png" alt="Boat" class="img-fluid me-2"
                    style="max-height: 40px;">
                <a class="navbar-brand amarante-regular fs-4 fs-lg-2 " href="index.php">The Artist Harbour</a>
                <!-- fs-4 = font size on mobile. fs-lg-2 = font size on large screen -->
            </div>

            <!-- Keeping navbar on the same line as above with margin start auto (ms-auto) pushes hamburger to the right of the nav bar on mobile-->
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Links to different pages on the navbar -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="profile.php">Business</a></li>
                </ul>

                <div class="d-flex align-items-center flex-grow-1">
                    <!-- Search Bar with symbol from a bootstrap class library -->
                    <form class="d-flex search-bar">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input class="form-control form-control-sm" type="search" placeholder="Search">
                        </div>
                    </form>

                    <!-- User Icon for navigating to profile of bussiness and user -->
                    <a href="profile.php"
                        class="btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 40px; height: 40px;">
                        <i class="bi bi-person"></i>
                    </a>
                </div>

            </div>
        </div>
    </nav>
</body>

</html>