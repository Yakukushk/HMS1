<?php

// src/Controller/RegistrationController.php
namespace App\Controller;

// ...
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController
{
    public function index(UserPasswordHasherInterface $passwordHasher)
    {
        // ... e.g. get the user data from a registration form
        $user = new User($passwordHasher);
        $plaintextPassword = $passwordHasher;

        // hash the password (based on the security.yaml config for the $user class)
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);

        // ...
    }
}
