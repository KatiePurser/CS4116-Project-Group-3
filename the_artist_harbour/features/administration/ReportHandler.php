<?php

require_once __DIR__ . '/../../utilities/DatabaseHandler.php';

class ReportHandler {
    public static function getAllReports(): array {
        $query = "SELECT * FROM reports
         ORDER BY
             CASE
                 WHEN status = 'pending' THEN 1
                 WHEN status = 'resolved' THEN 2
                 WHEN status = 'dismissed' THEN 3
             END,
             created_at DESC";
        $result = DatabaseHandler::make_select_query($query);
        return empty($result) ? [] : $result;

    }

    private static function deleteMessage(int $message_id): bool {
        $query = "DELETE FROM messages WHERE id = $message_id";
        $result = DatabaseHandler::make_modify_query($query);
        return $result === 1;
    }

    private static function deleteReview(int $review_id): bool {
        $query = "DELETE FROM reviews WHERE id = $review_id";
        $result = DatabaseHandler::make_modify_query($query);
        return $result === 1;
    }

    private static function deleteTarget(string $target_type, int $target_id): bool {
        $result = false;

        if ($target_type === "message") {
            $result = deleteMessage($target_id);
        } elseif ($target_type === "review") {
            $result = deleteReview($target_id);
        }
        return $result;
    }

    private static function resolveReport(int $report_id): bool {
        $query = "UPDATE reports SET status = 'resolved' WHERE id = $report_id";
        $result = DatabaseHandler::make_modify_query($query);
        return $result === 1;
    }

    private static function dismissReport(int $report_id): bool {
        $query = "UPDATE reports SET status = 'dismissed' WHERE id = $report_id";
        $result = DatabaseHandler::make_modify_query($query);
        return $result === 1;
    }

    private static function banUser(int $user_id, int $banned_by, string $ban_reason): bool {
        $query = "INSERT INTO banned_users (banned_user_id, banned_by, ban_reason) VALUES ($user_id, $banned_by, '$ban_reason')";
        $result = DatabaseHandler::make_modify_query($query);

        return $result === 1;
    }

    private static function deleteUser(int $user_id): bool {
        $query = "DELETE FROM users WHERE id = $user_id";
        $result = DatabaseHandler::make_modify_query($query);
        return $result === 1;
    }

    public static function banFunctionality(int $user_id, int $banned_by, string $ban_reason, int $report_id): bool {
        $user_banned = banUser($user_id, $banned_by, $ban_reason);
        $user_deleted = deleteUser($user_id);
        $report_resolved = resolveReport($report_id);
        return $user_banned && $user_deleted && $report_resolved;
    }

    public static function deleteFunctionality(string $target_type, int $target_id, int $report_id): bool {
        $target_deleted = deleteTarget($target_type, $target_id);
        $report_resolved = resolveReport($report_id);
        return $target_deleted && $report_resolved;
    }

    public static function dismissFunctionality(int $report_id): bool {
        $report_dismissed = dismissReport($report_id);
        return $report_dismissed;
    }
}