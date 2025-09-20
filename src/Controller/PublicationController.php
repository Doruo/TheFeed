<?php

namespace App\Controller;

use App\Repository\PublicationRepository;
use App\Service\FlashMessageHelperInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Publication;
use App\Form\PublicationType;
use DateTime;

final class PublicationController extends AbstractController
{
    public function __construct(private readonly FlashMessageHelperInterface $flashMessageHelper)
    {
    }

    #[Route('/', name: 'feed', methods: ["GET","POST"])]
    public function feed(Request $request, EntityManagerInterface $entityManager, PublicationRepository $publicationRepository): Response
    {
        // Création du formulaire
        $publication = new Publication();
        $publication->setDatePublication(new DateTime());
        $form = $this->createForm(PublicationType::class, $publication, [
            'method' => 'POST',
            'action' => $this->generateURL('feed'),
        ]);

        // Traitement du formulaire
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            // Ajoute publication à la base de donnée
            $entityManager->persist($publication);
            $entityManager->flush();

            $this->addFlash("success","Feed crée !");
            return $this->redirectToRoute('feed');
        }

        // Récupère toutes les publications en base de donnée
        $publications = $publicationRepository->findAll();
        // Gère les messages d'erreurs du formulaire
        $this->flashMessageHelper->addFormErrorsAsFlash($form);

        return $this->render('publication/feed.html.twig', [
           'publications'=> $publications,
           'form' => $form
        ]);
    }
}
