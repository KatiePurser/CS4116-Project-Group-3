<?php

require_once __DIR__ . '/../AdminUtilities.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request method']);
    exit();
}

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

if (!isset($data['user_id'], $data['banned_by'], $data['ban_reason'], $data['report_id'], $data['target_type'], $data['target_id'])) {
    echo json_encode(['error' => 'Missing required fields']);
    exit();
}

$userId = intval($data['user_id']);
$bannedBy = intval($data['banned_by']);
$banReason = htmlspecialchars($data['ban_reason']);
$reportId = intval($data['report_id']);
$targetType = htmlspecialchars($data['target_type']);
$targetId = intval($data['target_id']);

$result = AdminUtilities::banUserAction($userId, $bannedBy, $banReason, $reportId, $targetType, $targetId);

if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Failed to ban user']);
}