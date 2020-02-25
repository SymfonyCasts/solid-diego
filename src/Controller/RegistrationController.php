<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Manager\UserManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/signup", name="signup")
     */
    public function signup(
        Request $request,
        UserManager $userManager,
//        Mailer $mailer,
//        TokenGeneratorInterface $tokenGenerator,
        UserPasswordEncoderInterface $encoder,
        EntityManagerInterface $entityManager
    )
    {
        $form = $this->createForm(UserType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var $user User */
            $user = $form->getData();
            $plainPassword = $form->get('plain_password')->getData();

            // encode user password
            $userManager->setPassword($user, $plainPassword);

            // user storage
            $userManager->save($user);

            // user notification
            $token = $tokenGenerator->generate();
            $confirmationLink = $this->generateUrl('app_account_confirmation', ['token' => $token]);
            $mailer->sendConfirmationEmail($confirmationLink, $user->getEmail(), $user->getUsername());

            // flash message
            // return redirect
        }

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
