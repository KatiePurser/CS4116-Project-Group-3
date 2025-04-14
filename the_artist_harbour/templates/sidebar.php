<?php
$user_type = $_SESSION['user_type'] ?? '';
?>

<nav class="sidebar">
    <div class="sidebar-menu">
        <ul class="sidebar-nav-list">
            <?php if ($user_type === 'customer'): ?>
                <li class="sidebar-item">
                    <a class="sidebar-link"
                        href="/CS4116-Project-Group-3/the_artist_harbour/features/user/user_profile.php">
                        <i class="bi bi-person"></i>
                        <span class="sidebar-text d-none d-xl-inline">Account</span>
                    </a>
                </li>
            <?php elseif ($user_type === 'business'): ?>
                <li class="sidebar-item">
                    <a class="sidebar-link"
                        href="/CS4116-Project-Group-3/the_artist_harbour/features/user/user_profile.php">
                        <i class="bi bi-person"></i>
                        <span class="sidebar-text d-none d-xl-inline">Account</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="/CS4116-Project-Group-3/the_artist_harbour/features/business/account.php">
                        <i class="bi bi-house"></i>
                        <span class="sidebar-text d-none d-xl-inline">Business</span>
                    </a>
                </li>
            <?php endif; ?>
            <li class="sidebar-item">
                <a class="sidebar-link"
                    href="/CS4116-Project-Group-3/the_artist_harbour/features/service_request/service_request_page.php">
                    <i class="bi bi-briefcase"></i>
                    <span class="sidebar-text d-none d-xl-inline">Requests</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="/CS4116-Project-Group-3/the_artist_harbour/features/messages/inbox.php">
                    <i class="bi bi-envelope"></i>
                    <span class="sidebar-text d-none d-xl-inline">Messages</span>
                </a>
            </li>
        </ul>
    </div>
</nav>

<style>
    body {
        margin: 0;
        font-size: 16px;
    }


    .sidebar-text {
        padding-left: 10px;
    }

    .sidebar {
        position: fixed;
        top: 73.6px;
        left: 0;
        height: calc(100vh - 73.6px);
        background-color: #82689A;
        color: white;
        overflow-y: auto;
        width: 8.333%;
        justify-content: center;
        align-items: center;
    }

    .sidebar-menu {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 100%;
    }

    .sidebar-nav-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar-item {
        padding-top: 20px;
        padding-bottom: 20px;
    }

    .sidebar-link {
        color: white;
        text-decoration: none;
        font-weight: bold;
        display: flex;
        align-items: center;
        font-size: 1rem;
    }

    .sidebar-link:hover,
    .sidebar-link:focus {
        color: #49375a;
    }

    .dropdown-divider {
        height: 1px;
        background-color: white;
        border: none;
    }

    @media (max-width: 1200px) {
        .sidebar-link {
            justify-content: center;
        }

        .sidebar-link i {
            font-size: 1rem;
        }
    }

    @media (max-width: 992px) {
        .sidebar-link {
            justify-content: center;
        }

        .sidebar-link i {
            font-size: 1.2rem;
        }

    }

    @media (max-width: 768px) {
        .sidebar {
            width: 16.667%;
        }

        .sidebar-link {
            justify-content: center;
        }

        .sidebar-link i {
            font-size: 1.2rem;
        }
    }

    @media (max-width: 576px) {
        .sidebar-link {
            justify-content: center;
        }

        .sidebar-link i {
            font-size: 1.2rem;

        }
    }
</style>