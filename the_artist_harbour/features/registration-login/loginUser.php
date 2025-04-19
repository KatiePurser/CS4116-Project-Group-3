<?php

session_start();

require_once __DIR__ . '/../../utilities/DatabaseHandler.php';
require_once __DIR__ . '/../../utilities/InputValidationHelper.php';

try {
    $email = InputValidationHelper::validateEmail($_POST["email"] ?? null);
    $password = InputValidationHelper::validatePassword("Password", $_POST["password"] ?? null);


} catch (InvalidArgumentException $exception) {
    $_SESSION["error"] = $exception->getMessage();
    header("Location: login.php");
    exit();
}

$user_data = getUserByEmail($email);
if ($user_data === null) {
    $_SESSION["error"] = "Email is not registered.";
    header("Location: login.php");
    exit();
}

if (!verifyPassword($password, $user_data["password"])) {
    $_SESSION["error"] = "Incorrect password.";
    header("Location: login.php");
    exit();
}

if (isUserBanned($user_data["id"])) {
    print("Sorry, you are currently banned from using the platform.");
    exit();
}

$_SESSION["user_id"] = $user_data["id"];
$_SESSION["user_type"] = $user_data["user_type"];

if ($_SESSION["user_type"] === "customer") {
    header("Location: /CS4116-Project-Group-3/the_artist_harbour/public/home_page.php");
} elseif ($_SESSION["user_type"] === "business") {
    header("Location: /CS4116-Project-Group-3/the_artist_harbour/features/business/profile.php");
} elseif ($_SESSION["user_type"] === "admin") {
    header("Location: /CS4116-Project-Group-3/the_artist_harbour/features/administration/admin_panel.php");
}

function getUserByEmail(string $email) {
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = DatabaseHandler::make_select_query($query);
    return empty($result) ? null : $result[0];
}

function verifyPassword(string $password, string $hashedPassword): bool {
    return password_verify($password, $hashedPassword);
}

function isUserBanned(int $userId): bool {
    $query = "SELECT * FROM banned_users WHERE banned_user_id = $userId";
    $result = DatabaseHandler::make_select_query($query);
    return !empty($result);
}
