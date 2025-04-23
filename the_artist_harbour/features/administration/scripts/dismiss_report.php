<?php

require_once __DIR__ . '/../AdminUtilities.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request method']);
    exit();
}

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

if (!isset($data['report_id'])) {
    echo json_encode(['error' => 'Missing report ID']);
    exit();
}

$reportId = intval($data['report_id']);

$result = AdminUtilities::dismissReportAction($reportId);

if ($result) {
    echo json_encode(['success' => 'Report has been dismissed']);
} else {
    echo json_encode(['error' => 'Failed to dismiss report']);
}
