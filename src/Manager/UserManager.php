<?php

namespace App\Manager;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager
{
    private $passwordEncoder;
    private $entityManager;
    private $mailer;
    private $router;

    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer,
        RouterInterface $router
    )
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
        $this->router = $router;
    }

    public function register(User $user, string $plainPassword)
    {
        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, $plainPassword)
        );

        $token = $this->createToken();
        $user->setConfirmationToken($token);
        $confirmationLink = $this->router->generate('check_confirmation_link', [
            'token' => $user->getConfirmationToken()
        ]);

        $this->sendConfirmationEmail($user, $confirmationLink);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    private function sendConfirmationEmail(User $user, string $confirmationLink)
    {
        $confirmationEmail = (new Email())
            ->from('staff@example.com')
            ->to($user->getEmail())
            ->subject('Confirm your account')
            ->html($this->getConfirmationMessage($confirmationLink));

        $this->mailer->send($confirmationEmail);
    }

    private function createToken(): string
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }

    private function getConfirmationMessage(string $confirmationLink): string
    {
        return <<<eof
Thanks for subscribing to "example.com",
please follow this link to confirm your email account <a href="$confirmationLink">$confirmationLink</a>
eof;
    }
}
