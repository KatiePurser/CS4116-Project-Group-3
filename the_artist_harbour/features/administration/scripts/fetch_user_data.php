<?php

require_once __DIR__ . '/../AdminUtilities.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request method']);
    exit();
}

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

if (!isset($data['user_id'])) {
    echo json_encode(['error' => 'Missing user ID']);
    exit();
}

$userId = intval($data['user_id']);

$userData = AdminUtilities::fetchUserData($userId);

if (empty($userData)) {
    echo json_encode(['error' => 'Failed to fetch user data']);
} else {
    echo json_encode(['success' => 'User data fetched successfully', 'user_data' => $userData]);
}

