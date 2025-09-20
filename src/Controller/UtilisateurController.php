<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use App\Service\FlashMessageHelperInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UtilisateurController extends AbstractController
{
    public function __construct(private readonly FlashMessageHelperInterface $flashMessageHelper)
    {
    }

    #[Route('/inscription', name: 'inscription', methods: ['GET','POST'])]
    public function inscription(Request $request, EntityManagerInterface $entityManager, UtilisateurRepository $publicationRepository): Response
    {
        // Création du formulaire
        $utilisateur = new Utilisateur();
        
        $form = $this->createForm(UtilisateurType::class, $utilisateur, [
            'method' => 'POST',
            'action' => $this->generateURL('feed'),
        ]);

        // Traitement du formulaire
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            // Ajoute publication à la base de donnée
            $entityManager->persist($utilisateur);
            $entityManager->flush();

            return $this->redirectToRoute('feed');
        }

        // Gère les messages d'erreurs du formulaire
        $this->flashMessageHelper->addFormErrorsAsFlash($form);

        return $this->render('utilisateur/inscription.html.twig', [
        ]);
    }
}
