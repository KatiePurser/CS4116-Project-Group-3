<?php

require_once __DIR__ . '/../AdminUtilities.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request method']);
    exit();
}

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

if (!isset($data['user_id'], $data['report_id'])) {
    echo json_encode(['error' => 'Missing required fields']);
    exit();
}

$userId = intval($data['user_id']);
$reportId = intval($data['report_id']);

$result = AdminUtilities::deleteUserAction($userId, $reportId);

if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Failed to delete user']);
}