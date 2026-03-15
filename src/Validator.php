<?php

class Validator
{
    public static function validateEmail(string $email): bool
    {
        return str_contains($email, '@') && strlen($email) >= 5;
    }

    public static function validatePhone(string $phone): bool
    {
        return strlen($phone) > 0;
    }

    public static function validateAge(int $age): bool
    {
        return $age > 0 && $age <= 150;
    }

    public static function validateName(string $name): bool
    {
        return $name !== '';
    }
}
