<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\ConfirmationEmailSender;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResendConfirmationController extends AbstractController
{
    /**
     * @Route("/resend-confirmation", methods={"POST"})
     */
    public function resend(Request $request, UserRepository $userRepository, ConfirmationEmailSender $confirmationEmailSender)
    {
        $email = $request->request->get('email');

        $user = $userRepository->findOneBy(['email' => $email]);
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $confirmationEmailSender->send($user);

        return new Response(null, 204);
    }
}
