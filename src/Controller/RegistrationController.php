<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\RegistrationFormType;
use App\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/signup", name="signup")
     */
    public function signup(Request $request, UserManager $userManager)
    {
        $form = $this->createForm(RegistrationFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var $user User */
            $user = $form->getData();
            $plainPassword = $form->get('plainPassword')->getData();

            $userManager->register($user, $plainPassword);

            $this->addFlash('success', 'User created successfully');

            $this->redirectToRoute('home');
        }

        return $this->render('registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function resend(Request $request)
    {
        $email = $request->get('email');

        // fetch user
        // check not null


    }
}
