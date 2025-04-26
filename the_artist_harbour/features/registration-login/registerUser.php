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
    saveInputFieldsValues();
    header("Location: registration.php");
    exit();
}

if ($password !== $confirm_password) {
    $_SESSION['error'] = "Passwords do not match.";
    saveInputFieldsValues();
    header("Location: registration.php");
    exit();
}

if (getUserByEmail($email) !== null)  {
    $_SESSION['error'] = "Email is already registered.";
    saveInputFieldsValues();
    header("Location: registration.php");
    exit();
}

$new_user_data = createNewUser($email, $first_name, $last_name, $password, $user_type);

if ($new_user_data !== null) {
    $_SESSION["user_id"] = $new_user_data["id"];
    $_SESSION["user_type"] = $new_user_data["user_type"];
}

if ($user_type === "customer") {
    header("Location: /CS4116-Project-Group-3/the_artist_harbour/public/home_page.php");
} elseif ($user_type === "business") {
    createNewBusiness($_SESSION["user_id"], $business_name);
    header("Location: /CS4116-Project-Group-3/the_artist_harbour/features/business/account.php");
}

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

function saveInputFieldsValues(): void {
    if ($_POST["user_type"] === "customer") {
        $_SESSION['customer_email_address'] = $_POST["email"] ?? "";
        $_SESSION['customer_first_name'] = $_POST["first_name"] ?? "";
        $_SESSION['customer_last_name'] = $_POST["last_name"] ?? "";
        $_SESSION['customer_password'] = $_POST["password"] ?? "";
        $_SESSION['customer_confirm_password'] = $_POST["confirm_password"] ?? "";

    } else if ($_POST["user_type"] === "business") {
        $_SESSION['business_email_address'] = $_POST["email"] ?? "";
        $_SESSION['business_first_name'] = $_POST["first_name"] ?? "";
        $_SESSION['business_last_name'] = $_POST["last_name"] ?? "";
        $_SESSION['business_name'] = $_POST["business_name"] ?? "";
        $_SESSION['business_password'] = $_POST["password"] ?? "";
        $_SESSION['business_confirm_password'] = $_POST["confirm_password"] ?? "";
    }
}
