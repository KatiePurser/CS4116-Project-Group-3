<!-- Sidebar menu for large screens-->
<nav class="sidebar d-none d-lg-flex w-100">
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
        background-color: #82689A;
        height: 100vh;
        display: flex;
        flex-direction: column;
        width: 100%;
        border-top: 2px solid white;
        padding: none;
        position: sticky;
        top: 0;
    }

    .sidebar-menu {
        flex-grow: 1;
        margin-left: 10px;
        display: flex;
        flex-direction: column;
    }

    .sidebar-nav-list {
        list-style: none;
        padding: 0;
        margin: 0;
        flex-grow: 1;
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