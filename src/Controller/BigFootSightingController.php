<?php

namespace App\Controller;

use App\Entity\BigFootSighting;
use App\Service\SightingScorer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BigFootSightingController extends AbstractController
{
    /**
     * @Route("/sighting/new")
     */
    public function upload(Request $request, SightingScorer $sightingScorer, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(BigFootSightingType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var BigFootSighting $sighting */
            $sighting = $form->getData();

            $bigfootSightingScore = $sightingScorer->score($sighting);
            $sighting->setScore($bigfootSightingScore->getScore());

            $entityManager->persist($sighting);
            $entityManager->flush();

            $this->addFlash('success', 'New BigFoot Sighting created successfully');

            return $this->redirectToRoute('app_sighting_show', [
                'id' => $sighting->getId()
            ]);
        }

        return $this->render('bigFootSighting/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
