<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use App\Service\FlashMessageHelperInterface;
use App\Service\UtilisateurManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class UtilisateurController extends AbstractController
{
    public function __construct(
        private readonly FlashMessageHelperInterface $flashMessageHelper,
        private readonly UtilisateurManagerInterface $utilisateurManager,
        )
    {
    }

    #[Route('/inscription', name: 'inscription', methods: ['GET','POST'])]
    public function inscription(Request $request, EntityManagerInterface $entityManager, UtilisateurRepository $publicationRepository): Response
    {
        // Création du formulaire
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur, [
            'method' => 'POST',
            'action' => $this->generateURL('inscription'),
        ]);

        // Traitement du formulaire
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $this->utilisateurManager->processNewUtilisateur(
                $utilisateur, 
                $form["plainPassword"]->getData(), 
                $form["fichierPhotoProfil"]->getData(),
            );

            // Ajoute publication à la base de donnée
            $entityManager->persist($utilisateur);
            $entityManager->flush();

            $this->addFlash("success","Inscription réussie !");
            return $this->redirectToRoute('feed');
        }

        // Gère les messages d'erreurs du formulaire
        $this->flashMessageHelper->addFormErrorsAsFlash($form);

        return $this->render('utilisateur/inscription.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/connexion', name: 'connexion', methods: ['GET','POST'])]
    public function connexion(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('utilisateur/connexion.html.twig');
    }
}
