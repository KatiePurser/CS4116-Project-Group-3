<?php

const MIN_PASSWORD_LENGTH = 8;
const MAX_PASSWORD_LENGTH = 64;

const NAME_BASE_PATTERN = "[a-zA-Z-' ]"; // the regex base pattern for the name format, without the length constraints
const NAME_BASE_PATTERN_DESCRIPTION = "can only contain letters, hyphens, apostrophes, and spaces.";
const PASSWORD_BASE_PATTERN = "(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#?!@$%^&*-])[a-zA-Z\d#?!@$%^&*-]"; // the regex base pattern for the password format, without the length constraints
const PASSWORD_BASE_PATTERN_DESCRIPTION = "must include at least one uppercase letter, one lowercase letter, one number, and one special character (#?!@$%^&*-), and can only contain letters, numbers, and these special characters.";
const SEARCH_BASE_PATTERN = "[a-zA-Z0-9-' ]";
const SEARCH_BASE_PATTERN_DESCRIPTION = "can only include alphanumeric characters";
class InputValidationHelper {

    private static function regexComposer($base_pattern, $min_length, $max_length): string {
        return "/^" . $base_pattern . "{" . $min_length . "," . $max_length . "}$/";
    }

    public static function validateEmail(string|null $input_email): string {
        if ($input_email === null || trim($input_email) === "") {
            throw new InvalidArgumentException("Email is required.");
        }

        $email = trim($input_email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email address.");
        }
        return strtolower($email);
    }

    public static function validateString(string $field_name, string|null $value, string $base_pattern, string $base_pattern_description, int $min_length, int $max_length): string {
        if ($value === null || trim($value) === "") {
            throw new InvalidArgumentException("$field_name is required.");
        }

        $string = trim($value);

        if (strlen($string) < $min_length || strlen($string) > $max_length) {
            throw new InvalidArgumentException("$field_name must be between $min_length and $max_length characters.");
        }

        $pattern = self::regexComposer($base_pattern, $min_length, $max_length);
        if (!preg_match($pattern, $string)) {
            throw new InvalidArgumentException("$field_name $base_pattern_description");
        }

        return $string;
    }

    public static function validateName(string $field_name, string|null $value, int $min_length, int $max_length): string {
        return self::validateString($field_name, $value, NAME_BASE_PATTERN, NAME_BASE_PATTERN_DESCRIPTION, $min_length, $max_length);
    }
    public static function validatePassword(string $field_name, string|null $value): string {
        return self::validateString($field_name, $value, PASSWORD_BASE_PATTERN, PASSWORD_BASE_PATTERN_DESCRIPTION, MIN_PASSWORD_LENGTH, MAX_PASSWORD_LENGTH);
    }
}