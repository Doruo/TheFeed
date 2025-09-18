<?php

namespace App\Controller;

use App\Service\FlashMessageHelper;
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
    public function __construct(private readonly FlashMessageHelper $flashMessageHelper)
    {
    }

    #[Route('/', name: 'feed', methods: ["GET","POST"])]
    public function createPublication(Request $request, EntityManagerInterface $entityManager, FlashMessageHelperInterface $flashMessageHelper): Response
    {
        $publication1 = new Publication();
        $publication1->setMessage("Coucou");
        $publication1->setDatePublication(new DateTime());

        $publication2 = new Publication();
        $publication2->setMessage("Salut");
        $publication2->setDatePublication(new DateTime());

        $publications = array($publication1, $publication2);

        // Formulaire
        $publication = new Publication();
        $publication->setDatePublication(new DateTime());
        $form = $this->createForm(PublicationType::class, $publication, [
            'method' => 'POST',
            'action' => $this->generateURL('feed'),
        ]);

        //Traitement du formulaire
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($publication);
            $entityManager->flush();

            return $this->redirectToRoute('feed');
        }

        $this->flashMessageHelper->addFormErrorsAsFlash($form);

        return $this->render('publication/feed.html.twig', [
           'publications'=> $publications,
           'form' => $form
        ]);
    }
}
