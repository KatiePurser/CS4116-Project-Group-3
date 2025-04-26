<?php

require_once __DIR__ . '/../../utilities/DatabaseHandler.php';

class AdminUtilities {
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

    public static function getAllBannedUsers(): array {
        $query = "SELECT * FROM banned_users ORDER BY ban_date DESC";
        $result = DatabaseHandler::make_select_query($query);
        return empty($result) ? [] : $result;
    }

    public static function fetchUserData($userId): array {
        $query = "SELECT * FROM users WHERE id = $userId";
        $result = DatabaseHandler::make_select_query($query);

        return empty($result) ? [] : $result[0];
    }

    private static function dismissReport(int $report_id): bool {
        $query = "UPDATE reports SET status = 'dismissed' WHERE id = $report_id";
        $result = DatabaseHandler::make_modify_query($query);
        return $result === 1;
    }

    private static function resolveReport(int $report_id): bool {
        $query = "UPDATE reports SET status = 'resolved' WHERE id = $report_id";
        $result = DatabaseHandler::make_modify_query($query);
        return $result === 1;
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
            $result = self::deleteMessage($target_id);
        } elseif ($target_type === "review") {
            $result = self::deleteReview($target_id);
        }
        return $result;
    }

    private static function banUser(int $user_id, int $banned_by, string $ban_reason): bool {
        $query = "INSERT INTO banned_users (banned_user_id, banned_by, ban_reason) VALUES ($user_id, $banned_by, '$ban_reason')";
        $result = DatabaseHandler::make_modify_query($query);

        return $result === 1;
    }

    private static function unbanUser(int $user_id): bool {
        $query = "DELETE FROM banned_users WHERE banned_user_id = $user_id";
        $result = DatabaseHandler::make_modify_query($query);
        return $result === 1;
    }

    private static function deleteUser(int $user_id): bool {
        $query = "DELETE FROM users WHERE id = $user_id";
        $result = DatabaseHandler::make_modify_query($query);
        return $result === 1;
    }

    public static function dismissReportAction(int $report_id): bool {
        $report_dismissed = self::dismissReport($report_id);
        return $report_dismissed;
    }

    public static function deleteTargetAction(string $target_type, int $target_id, int $report_id): bool {
        $target_deleted = self::deleteTarget($target_type, $target_id);
        $report_resolved = self::resolveReport($report_id);
        return $target_deleted && $report_resolved;
    }

    public static function banUserAction(int $user_id, int $banned_by, string $ban_reason, int $report_id): bool {
        $user_banned = self::banUser($user_id, $banned_by, $ban_reason);
        $report_resolved = self::resolveReport($report_id);
        return $user_banned && $report_resolved;
    }

    public static function unbanUserAction(int $user_id): bool {
        $user_unbanned = self::unbanUser($user_id);
        return $user_unbanned;
    }

    public static function deleteUserAction(int $user_id, int $report_id): bool {
        $user_deleted = self::deleteUser($user_id);
        $report_resolved = self::resolveReport($report_id);
        return $user_deleted && $report_resolved;
    }
}