<!-- Dropdown menu for small screens-->
<div class="dropdown-container d-lg-none p-2">
    <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
            Dashboard
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Account Details</a></li>
            <li><a class="dropdown-item" href="#">Service Requests</a></li>
            <li><a class="dropdown-item" href="#">Business Profile</a></li>
            <li><a class="dropdown-item" href="#">Messages</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li>
                <button class="dropdown-item sidebar-sign-out-button">Sign Out</button>
            </li>
        </ul>
    </div>
</div>

<!-- Sidebar menu for large screens-->
<nav class="sidebar d-none d-lg-flex">
    <div class="sidebar-menu">
        <ul class="sidebar-nav-list">
            <li class="sidebar-item"><a class="sidebar-link" href="#">Account Details</a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="#">Service Requests</a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="#">Business Profile</a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="#">Messages</a></li>
        </ul>
    </div>
</nav>

<style>
    body {
        margin: 0;
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

    }

    .sidebar-menu {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        width: 100%
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

    .dropdown-container {
        position: fixed;
    }

    .dropdown-menu {
        background-color: #82689A;
        text-align: center;
        color: white;
    }

    .dropdown-item {
        color: white;
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

    .dropdown-toggle:active {
        background-color: #49375a !important;
        box-shadow: none;
    }

    @media (max-width: 991px) {
        .sidebar {
            width: 100%;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>