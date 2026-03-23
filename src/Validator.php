<?php

class Validator
{
    public static function validateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function validatePhone(string $phone): bool
    {
        return strlen($phone) > 0;
    }

    public static function validateAge(int $age): bool
    {
        return $age > 0 && $age <= 150;
    }

    public static function validateAgeInput(string $input): ?int
    {
        if (!ctype_digit($input)) {
            return null;
        }

        $age = (int) $input;

        return self::validateAge($age) ? $age : null;
    }

    public static function validateName(string $name): bool
    {
        return $name !== '';
    }
}
