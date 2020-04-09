<?php

namespace App\Manager;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager
{
    private $passwordEncoder;
    private $entityManager;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
    }

    public function create(User $user, string $plainPassword): User
    {
        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, $plainPassword)
        );

        $token = $this->createToken();
        $user->setConfirmationToken($token);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    private function createToken(): string
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }
}
