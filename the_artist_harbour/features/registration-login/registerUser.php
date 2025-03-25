<?php

session_start();

require_once __DIR__ . '/../../utilities/DatabaseHandler.php';
require_once __DIR__ . '/../../utilities/InputValidationHelper.php';

try {
    $email = InputValidationHelper::validateEmail($_POST["email"] ?? null);
    $first_name = InputValidationHelper::validateName("First Name", $_POST["first_name"] ?? null, 2,50);
    $last_name = InputValidationHelper::validateName("Last Name", $_POST["last_name"] ?? null, 2, 50);

    $user_type = $_POST["user_type"]; // always comes from a hidden input field, so always has a value
    if ($user_type === "business") {
        $business_name = InputValidationHelper::validateName("Business Name", $_POST["business_name"] ?? null, 2, 100);
    }

    $password = InputValidationHelper::validatePassword("Password", $_POST["password"] ?? null);
    $confirm_password = InputValidationHelper::validatePassword("Confirm Password", $_POST["confirm_password"] ?? null);

} catch (InvalidArgumentException $exception) {
    $_SESSION['error'] = $exception->getMessage();
    header("Location: registration.php");
    exit();
}

if ($password !== $confirm_password) {
    $_SESSION['error'] = "Passwords do not match.";
    header("Location: registration.php");
    exit();
}

if (getUserByEmail($email) !== null)  {
    $_SESSION['error'] = "Email is already registered.";
    header("Location: registration.php");
    exit();
}

$new_user_data = createNewUser($email, $first_name, $last_name, $password, $user_type);

if ($new_user_data !== null) {
    $_SESSION["user_id"] = $new_user_data["id"];
    $_SESSION["user_type"] = $new_user_data["user_type"];
}

if ($user_type === "business") {
    createNewBusiness($_SESSION["user_id"], $business_name);
    header("Location: ../business/account.php");
    exit();
}

header("Location: fakeHomePage.php");

function getUserByEmail(string $email) {
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = DatabaseHandler::make_select_query($query);
    return empty($result) ? null : $result[0];
}

function createNewUser(string $email, string $first_name, string $last_name, string $password, string $user_type): array|null {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO users (email, first_name, last_name, password, user_type) VALUES ('$email', '$first_name', '$last_name', '$hashed_password', '$user_type')";
    $result = DatabaseHandler::make_modify_query($query);
    return $result === 1 ? getUserByEmail($email) : null;
}

function createNewBusiness(int $user_id, string $business_name): bool {
    $query = "INSERT INTO businesses (user_id, display_name) VALUES ($user_id, '$business_name')";
    $result = DatabaseHandler::make_modify_query($query);
    return $result === 1;
}
