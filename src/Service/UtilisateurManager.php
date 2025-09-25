<?php

namespace App\Service;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UtilisateurManager implements UtilisateurManagerInterface
{

    public function __construct(
        //Injection du paramètre dossier_photo_profil
        #[Autowire('%dossier_photo_profil%')] private string $photo_path,
        //Injection du service UserPasswordHasherInterface
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly EntityManagerInterface $entityManager,
    ) {}

    /**
     * Chiffre le mot de passe puis l'affecte au champ correspondant dans la classe de l'utilisateur
     */
    private function chiffrerMotDePasse(Utilisateur $utilisateur, ?string $plainPassword): void
    {
        //On chiffre le mot de passe en clair
        $hashed = $this->passwordHasher->hashPassword($utilisateur, $plainPassword);
        //On met à jour l'attribut "password" de l'utilisateur
        $utilisateur->setPassword($hashed);
    }

    /**
     * Sauvegarde l'image de profil dans le dossier de destination puis affecte son nom au champ correspondant dans la classe de l'utilisateur
     */
    private function sauvegarderPhotoProfil(Utilisateur $utilisateur, ?UploadedFile $fichierPhotoProfil): void
    {
        if ($fichierPhotoProfil != null) {
            //On configure le nom de l'image à sauvegarder
            $fileName = uniqid($utilisateur->getLogin()) . '.' . $fichierPhotoProfil->guessExtension();
            //On la déplace vers son dossier de destination
            $fichierPhotoProfil->move($this->photo_path, $fileName);
            //On met à jour l'attribut "nomPhotoProfil" de l'utilisateur
            $utilisateur->setNomPhotoProfil($fileName);
        }
    }

    /**
     * Réalise toutes les opérations nécessaires avant l'enregistrement en base d'un nouvel utilisateur, après soumissions du formulaire (hachage du mot de passe, sauvegarde de la photo de profil...)
     */
    public function processNewUtilisateur(Utilisateur $utilisateur, ?string $plainPassword, ?UploadedFile $fichierPhotoProfil): void
    {
        //On chiffre le mot de passe
        $this->chiffrerMotDePasse($utilisateur, $plainPassword);
        //On sauvegarde (et on déplace) l'image de profil
        $this->sauvegarderPhotoProfil($utilisateur, $fichierPhotoProfil);
    
        // Ajoute publication à la base de donnée
        $this->entityManager->persist($utilisateur);
        $this->entityManager->flush();
    }
}
