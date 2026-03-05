<?php

class Validador
{
    public static function validarEmail(string $email): bool
    {
        return str_contains($email, '@') && strlen($email) >= 5;
    }

    public static function validarTelefone(string $telefone): bool
    {
        return strlen($telefone) > 0;
    }

    public static function validarIdade(int $idade): bool
    {
        return $idade > 0 && $idade <= 150;
    }

    public static function validarNome(string $nome): bool
    {
        return $nome !== '';
    }
}
