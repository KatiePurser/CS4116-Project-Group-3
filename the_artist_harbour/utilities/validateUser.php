<?php
require_once __DIR__ . '/BannedAndDeletedUsersHandler.php';

if (!isset($_SESSION['user_id'])) { // if a user is not logged in, bring them to the login page
    header("Location: /CS4116-Project-Group-3/the_artist_harbour/features/registration-login/login.php");
    exit();
}

if (BannedAndDeletedUsersHandler::hasUserWithEmailBeenDeleted($_SESSION['email'])) {
    $_SESSION = [];
    session_destroy();
    print("Sorry, your account has been deleted and cannot be used anymore.");
    exit();
}

if (BannedAndDeletedUsersHandler::isUserBanned($_SESSION['user_id'])) {
    $_SESSION = [];
    session_destroy();
    print("Sorry, you are currently banned from using the platform.");
    exit();
}
