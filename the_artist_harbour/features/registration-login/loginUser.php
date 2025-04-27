<?php

session_start();

require_once __DIR__ . '/../../utilities/databaseHandler.php';
require_once __DIR__ . '/../../utilities/InputValidationHelper.php';
require_once __DIR__ . '/../../utilities/BannedAndDeletedUsersHandler.php';

try {
    $email = htmlspecialchars(InputValidationHelper::validateEmail($_POST["email"] ?? null));
    $password = InputValidationHelper::validatePassword("Password", $_POST["password"] ?? null);


} catch (InvalidArgumentException $exception) {
    $_SESSION["error"] = $exception->getMessage();
    saveInputFieldsValues();
    header("Location: login.php");
    exit();
}

$user_data = getUserByEmail($email);
if ($user_data === null) {
    $_SESSION["error"] = "Email is not registered.";
    saveInputFieldsValues();
    header("Location: login.php");
    exit();
}

if (!verifyPassword($password, $user_data["password"])) {
    $_SESSION["error"] = "Incorrect password.";
    saveInputFieldsValues();
    header("Location: login.php");
    exit();
}

if (BannedAndDeletedUsersHandler::isUserBanned($user_data["id"])) {
    print ("Sorry, you are currently banned from using the platform.");
    exit();
}

$_SESSION["user_id"] = $user_data["id"];
$_SESSION["user_type"] = $user_data["user_type"];
$_SESSION["email"] = $user_data["email"];

if ($_SESSION["user_type"] === "customer") {
    header("Location: /the_artist_harbour/public/home_page.php");
} elseif ($_SESSION["user_type"] === "business") {
    header("Location: /the_artist_harbour/features/business/profile.php");
} elseif ($_SESSION["user_type"] === "admin") {
    header("Location: /the_artist_harbour/features/administration/admin_panel.php");
}

function getUserByEmail(string $email)
{
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = DatabaseHandler::make_select_query($query);
    return empty($result) ? null : $result[0];
}

function verifyPassword(string $password, string $hashedPassword): bool
{
    return password_verify($password, $hashedPassword);
}

function saveInputFieldsValues(): void
{
    $_SESSION["email_address"] = $_POST["email"] ?? "";
    $_SESSION["password"] = $_POST["password"] ?? "";
}