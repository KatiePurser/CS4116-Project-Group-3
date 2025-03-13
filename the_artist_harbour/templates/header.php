<nav class="navbar navbar-expand-lg">
    <div class="container d-flex align-items-center justify-content-between">

        <div class="d-flex align-items-center flex-grow-1">
            <img src="/the_artist_harbour/public/images/boat_logo_small.png" alt="Boat" class="img-fluid me-2"
                style="max-height: 40px;">
            <a class="navbar-brand amarante-regular fs-4 fs-lg-2" href="index.php">The Artist Harbour</a>
        </div>

        <!-- Keeping navbar on the same line as above with margin start auto (ms-auto) pushes hamburger to the right of the nav bar on mobile -->
        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
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
        background-color: #82689A;
        width: 100%;
        position: sticky;
        top: 0;
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
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>