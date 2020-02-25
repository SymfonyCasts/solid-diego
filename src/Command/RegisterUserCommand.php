<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterUserCommand extends Command
{
    protected static $defaultName = 'app:user:register';

    private $entityManager;
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    protected function configure()
    {
        $this
            ->setDescription('Create a new user')
            ->addArgument('email', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $email = $input->getArgument('email');
        $plainPassword = $this->generateRandomPassword();

        $user = new User();
        $user->setEmail($email);
        $user->setAgreedToTermsAt(new \DateTime());
        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, $plainPassword)
        );

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $io->success('User created successfully');

        $io->note('Please do not forget to send an email to the user with his credentials. The user will be asked to change his password after login in');
        $io->writeln('Email: ' . $user->getEmail());
        $io->writeln('Password: ' . $user->getPassword());

        return 0;
    }

    private function generateRandomPassword(): string
    {
        return '123';
    }
}
