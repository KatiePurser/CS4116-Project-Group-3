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

$result = AdminUtilities::unbanUserAction($userId);

if ($result) {
    echo json_encode(['success' => 'User has been unbanned']);
} else {
    echo json_encode(['error' => 'Failed to unban user']);
}
