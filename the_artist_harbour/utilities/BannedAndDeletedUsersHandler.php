<?php

class BannedAndDeletedUsersHandler {

    public static function hasUserWithEmailBeenDeleted(string $email): bool {
        $query = "SELECT * FROM deleted_users WHERE email = '$email'";
        $result = DatabaseHandler::make_select_query($query);
        return !empty($result);
    }

    public static function isUserBanned(int $userId): bool {
        $query = "SELECT * FROM banned_users WHERE banned_user_id = $userId";
        $result = DatabaseHandler::make_select_query($query);
        return !empty($result);
    }
}