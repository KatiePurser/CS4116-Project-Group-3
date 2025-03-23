<nav class="navbar navbar-expand-lg">
    <div class="container d-flex align-items-center justify-content-between">

        <div class="d-flex align-items-center flex-grow-1">
            <img src="/CS4116-Project-Group-3/the_artist_harbour/public/images/boat_logo_small.png" alt="Boat"
                class="img-fluid me-2" style="max-height: 40px;">
            <a class="navbar-brand amarante-regular fs-4 fs-lg-2" href="index.php">The Artist Harbour</a>
        </div>

        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Navigation Links -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                <li class="nav-item"><a class="nav-link" href="profile.php">Business</a></li>
            </ul>

            <div class="d-flex align-items-center flex-grow-1">
                <!-- Search Bar  -->
                <form class="d-flex search-bar">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input class="form-control form-control-sm" type="search" placeholder="Search">
                    </div>
                </form>

                <!-- User Icon -->
                <a href="profile.php"
                    class="btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center"
                    style="width: 40px; height: 40px;">
                    <i class="bi bi-person"></i>
                </a>
            </div>

        </div>
    </div>
</nav>

<style>
    .navbar {
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1000;
        background-color: #82689A;
        height: 73.6px;
        border-bottom: #B3AABA 2px solid;
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
        width: 100%;
    }

    .navbar-collapse {
        background-color: #82689A !important;
    }

    .navbar-toggler {
        height: 40px;
    }

    .navbar-toggler-icon {
        color: white;
    }

    .btn-outline-light {
        color: white;
        border-color: white;
    }

    .btn-outline-light:hover {
        color: #49375a;
        border-color: #49375a;
    }

    @media (max-width: 992px) {
        .navbar-collapse {
            position: absolute;
            top: 73.6px;
            left: 0;
            width: 100%;
            background-color: #82689A;
            padding: 20px;
        }

        .nav-item {
            margin-left: 3%;
        }

        .search-bar {
            margin-left: 2%;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>