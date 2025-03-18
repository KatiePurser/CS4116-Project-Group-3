<nav class="sidebar">
    <div class="sidebar-menu">
        <ul class="sidebar-nav-list">
            <li class="sidebar-item">
                <a class="sidebar-link" href="#">
                    <i class="bi bi-person"></i>
                    <span class="d-none d-xl-inline">Account Details</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="#">
                    <i class="bi bi-briefcase"></i>
                    <span class="d-none d-xl-inline">Service Requests</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="#">
                    <i class="bi bi-building"></i>
                    <span class="d-none d-xl-inline">Business Profile</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="#">
                    <i class="bi bi-envelope"></i>
                    <span class="d-none d-xl-inline">Messages</span>
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

    .sidebar {
        position: fixed;
        top: 73.6px;
        left: 0;
        height: calc(100vh - 73.6px);
        background-color: #82689A;
        color: white;
        overflow-y: auto;
        width: 8.333%;
        transition: width 0.3s;
    }

    .sidebar-menu {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .sidebar-nav-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar-item {
        padding-top: 20px;
        padding-left: 10px;
        padding-bottom: 20px;
    }

    .sidebar-link {
        color: white;
        text-decoration: none;
        font-weight: bold;
        display: flex;
        align-items: center;
        font-size: 0.9rem;
    }

    .sidebar-link i {
        margin-right: 10px;
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
            font-size: 1.2rem;
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>