<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Publication;
use App\Form\PublicationType;
use DateTime;

final class PublicationController extends AbstractController
{
    #[Route('/', name: 'feed')]
    public function index(): Response
    {
        $publication1 = new Publication();
        $publication1->setMessage("Coucou");
        $publication1->setDatePublication(new DateTime());

        $publication2 = new Publication();
        $publication2->setMessage("Salut");
        $publication2->setDatePublication(new DateTime());

        $publications = array($publication1, $publication2);

        //$publicationRepository->add($publication1);

        // Formulaire
        $form = $this->createForm(PublicationType::class, $publication1, [
        //On précise la méthode utilisée par le formulaire (GET, POST, ...)
        'method' => 'POST',
        //On précise l'URL vers lequel le formulaire sera envoyé.
        //La méthode generateURL permet de générer une URL à partir du nom d'une route (pas son chemin!) 
        'action' => $this->generateURL('feed')
        ]);

        return $this->render('publication/feed.html.twig', [
           'publications'=> $publications,
           'form' => $form
        ]);
    }
}
