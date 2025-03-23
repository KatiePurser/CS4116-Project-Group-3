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

$_SESSION["user_id"] = $user_data["id"];
$_SESSION["user_type"] = $user_data["user_type"];

header("Location: fakeHomePage.php");


function getUserByEmail(string $email) {
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = DatabaseHandler::make_select_query($query);
    return empty($result) ? null : $result[0];
}

function verifyPassword(string $password, string $hashedPassword): bool {
    return password_verify($password, $hashedPassword);
}