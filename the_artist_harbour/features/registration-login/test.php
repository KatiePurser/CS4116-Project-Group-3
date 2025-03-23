<?php

require_once __DIR__ . '/../../utilities/DatabaseHandler.php';


function getUserByEmail(string $email) {
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = DatabaseHandler::make_select_query($query);
    return empty($result) ? null : $result[0];
}

print_r(getUserByEmail('alice.johnson@email.com')["id"]);