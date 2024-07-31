<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

class NotificationService {

    private PasswordHasherFactoryInterface $passwordHasherFactory;

    public function __construct(PasswordHasherFactoryInterface $passwordHasherFactory) {
        $this->passwordHasherFactory = $passwordHasherFactory;
    }

    public function sendMail(User $user) {
        dump("Envoi d'un mail");
        dump("Bonjour " . $user->getUserIdentifier());
        $factory = $this->passwordHasherFactory->getPasswordHasher($user);
        dump($factory->verify($user->getPassword(), "password"));
    }
}