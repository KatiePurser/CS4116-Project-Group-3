<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyApp</title>

    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .nav-item .nav-link {
            color: white;
        }

        .left-navbar {
            background-color: #82689A;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 10%;
        }

        /* When dropdown appears for small screen this hides the background */
        @media (max-width: 991px) {
            .left-navbar {
                background-color: transparent;
                width: 100%;
            }
        }

        .dropdown-container {
            display: flex;
            justify-content: center;
            width: 100%;
        }

        .dropdown-menu {
            background-color: #82689A;
            text-align: center;
        }

        .dropdown-toggle {
            background-color: #82689A;
            color: white;
            border: none;
        }

        .dropdown-toggle:hover {
            background-color: #49375a;
        }

        .dropdown-toggle:focus {
            background-color: #49375a !important;
            box-shadow: none;
        }
    </style>
</head>

<body>
    <div class="left-navbar navbar">
        <div class="container-fluid">
            <!-- Menu for large screens -->
            <div class="d-none d-lg-block">
                <ul class="navbar-nav d-flex flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Account Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Service Requests</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Business Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Messages</a>
                    </li>
                </ul>
            </div>

            <!-- Dropdown menu for smaller screens -->
            <div class="d-lg-none dropdown-container">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Dashboard
                    </button>
                    <ul class="dropdown-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Account Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Service Requests</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Business Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Messages</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</body>

</html>