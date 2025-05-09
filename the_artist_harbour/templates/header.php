<?php
$user_type = $_SESSION['user_type'] ?? 'customer';
?>

<?php if ($user_type === 'customer'): ?>
    <nav class="navbar navbar-expand-lg">
        <div class="container">

            <div class="d-flex align-items-center flex-grow-1">
                <img src="/CS4116-Project-Group-3/the_artist_harbour/public/images/boat_logo_small.png" alt="Boat"
                    class="img-fluid me-2" style="max-height: 40px;">
                <a class="navbar-brand amarante-regular fs-4 fs-lg-2"
                    href="/CS4116-Project-Group-3/the_artist_harbour/public/home_page.php">The Artist Harbour</a>
            </div>

            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="d-flex align-items-center flex-grow-1">

                    <!-- Search Bar -->
                    <form class="d-flex search-bar" method="get"
                        action="/CS4116-Project-Group-3/the_artist_harbour/features/search/search_page.php">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input class="form-control form-control-sm" type="search" placeholder="Search" name="search">
                        </div>
                    </form>

                    <!-- User Profile Dropdown -->
                    <div class="dropdown">
                        <button
                            class="menu-dropdown btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center dropdown-toggle"
                            style="width: 40px; height: 40px;" type="button" id="userDropdown" data-bs-toggle="dropdown">
                            <i class="bi bi-person"></i>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item"
                                    href="/CS4116-Project-Group-3/the_artist_harbour/features/messages/inbox.php">Messages</a>
                            </li>
                            <li><a class="dropdown-item"
                                    href="/CS4116-Project-Group-3/the_artist_harbour/features/service_request/service_request_page.php">Requests</a>
                            </li>
                            <li><a class="dropdown-item"
                                    href="/CS4116-Project-Group-3/the_artist_harbour/features/user/user_profile.php">Account
                                    Details</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item"
                                    href="/CS4116-Project-Group-3/the_artist_harbour/features/registration-login/logout.php"><i
                                        class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
    </nav>
<?php elseif ($user_type === 'business'): ?>
    <nav class="navbar navbar-expand-lg">
        <div class="container position-relative d-flex align-items-center">

            <!-- Centered Logo and Brand -->
            <div class="position-absolute start-50 translate-middle-x d-flex align-items-center">
                <img src="/CS4116-Project-Group-3/the_artist_harbour/public/images/boat_logo_small.png" alt="Boat"
                    class="img-fluid me-2" style="max-height: 40px;">
                <a class="navbar-brand amarante-regular fs-4 fs-lg-2"
                    href="/CS4116-Project-Group-3/the_artist_harbour/features/business/profile.php">The Artist Harbour</a>
            </div>

            <div class="d-flex align-items-center ms-auto">
                <!-- User Profile Dropdown -->
                <div class="dropdown">
                    <button
                        class="menu-dropdown btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center dropdown-toggle"
                        style="width: 40px; height: 40px;" type="button" id="userDropdown" data-bs-toggle="dropdown">
                        <i class="bi bi-person"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item"
                                href="/CS4116-Project-Group-3/the_artist_harbour/features/user/user_profile.php">Account
                                Details</a>
                        </li>
                        <li><a class="dropdown-item"
                                href="/CS4116-Project-Group-3/the_artist_harbour/features/business/profile.php">Business
                                Profile</a>
                        </li>


                        <li><a class="dropdown-item"
                                href="/CS4116-Project-Group-3/the_artist_harbour/features/business/account.php">Business
                                Details</a>
                        </li>
                        <li><a class="dropdown-item"
                                href="/CS4116-Project-Group-3/the_artist_harbour/features/service_request/service_request_page.php">Requests</a>
                        </li>
                        <li><a class="dropdown-item"
                                href="/CS4116-Project-Group-3/the_artist_harbour/features/messages/inbox.php">Messages</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item"
                                href="/CS4116-Project-Group-3/the_artist_harbour/features/registration-login/logout.php"><i
                                    class="bi bi-box-arrow-right me-2"></i>Logout</a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </nav>
<?php elseif ($user_type === 'admin'): ?>
    <nav class="navbar navbar-expand-lg">
        <div class="container position-relative d-flex align-items-center">

            <!-- Centered Logo and Brand -->
            <div class="position-absolute start-50 translate-middle-x d-flex align-items-center">
                <img src="/CS4116-Project-Group-3/the_artist_harbour/public/images/boat_logo_small.png" alt="Boat"
                    class="img-fluid me-2" style="max-height: 40px;">
                <a class="navbar-brand amarante-regular fs-4 fs-lg-2"
                    href="/CS4116-Project-Group-3/the_artist_harbour/features/administration/admin_panel.php">The Artist
                    Harbour</a>
            </div>

            <div class="d-flex align-items-center ms-auto">
                <!-- User Profile Dropdown -->
                <div class="dropdown">
                    <button
                        class="menu-dropdown btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center dropdown-toggle"
                        style="width: 40px; height: 40px;" type="button" id="userDropdown" data-bs-toggle="dropdown">
                        <i class="bi bi-person"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item"
                                href="/CS4116-Project-Group-3/the_artist_harbour/features/administration/admin_panel.php">Report
                                Logs</a>
                        </li>
                        <li><a class="dropdown-item"
                                href="/CS4116-Project-Group-3/the_artist_harbour/features/administration/banned_users.php">Banned
                                Users</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item"
                                href="/CS4116-Project-Group-3/the_artist_harbour/features/registration-login/logout.php"><i
                                    class="bi bi-box-arrow-right me-2"></i>Logout</a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </nav>
<?php elseif ($user_type === ''): ?>
    <nav class="navbar navbar-expand-lg">
        <div class="container position-relative d-flex align-items-center">
            <!-- Centered Logo and Brand -->
            <div class="position-absolute start-50 translate-middle-x d-flex align-items-center">
                <img src="/CS4116-Project-Group-3/the_artist_harbour/public/images/boat_logo_small.png" alt="Boat"
                    class="img-fluid me-2" style="max-height: 40px;">
                <span class="navbar-brand amarante-regular fs-4 fs-lg-2">The Artist Harbour</span>
            </div>
        </div>
    </nav>
<?php endif; ?>
</div>

<style>
    .menu-dropdown {
        margin-right: 5px;
    }

    .navbar {
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1000;
        background-color: #82689A;
        height: 73.6px;
        border-bottom: #B3AABA 2px solid;
    }

    .navbar-brand:active,
    .navbar-brand:focus {
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

    .dropdown-menu {
        background-color: #ac8ebf !important;
        border: none;
    }

    .dropdown-item {
        color: white !important;
    }

    .dropdown-item:hover {
        background-color: #c3b5d1 !important;
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