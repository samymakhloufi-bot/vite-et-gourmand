<?php
const PASSWORD_MIN_LENGTH = 10;
const PASSWORD_MAX_LENGTH = 255;

function password_validation_error(mixed $password): ?string
{
    $requirementsMessage = 'Le mot de passe doit contenir entre 10 et 255 caractères, avec au moins une majuscule, une minuscule, un chiffre et un caractère spécial.';

    if (!is_string($password)) {
        return $requirementsMessage;
    }

    $length = strlen($password);

    if ($length < PASSWORD_MIN_LENGTH || $length > PASSWORD_MAX_LENGTH) {
        return $requirementsMessage;
    }

    if (
        !preg_match('/[a-z]/', $password)
        || !preg_match('/[A-Z]/', $password)
        || !preg_match('/[0-9]/', $password)
        || !preg_match('/[^a-zA-Z0-9\s]/', $password)
    ) {
        return $requirementsMessage;
    }

    return null;
}
