<?php

namespace App\Service;

 use App\Entity\Utilisateur;
 use Symfony\Component\DependencyInjection\Attribute\Autowire;
 use Symfony\Component\HttpFoundation\File\UploadedFile;
 use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

 class UtilisateurManager implements UtilisateurManagerInterface{

     public function __construct(
         //Injection du paramètre dossier_photo_profil
         //Injection du service UserPasswordHasherInterface
     ){}

     /**
      * Chiffre le mot de passe puis l'affecte au champ correspondant dans la classe de l'utilisateur
      */
     private function chiffrerMotDePasse(Utilisateur $utilisateur, ?string $plainPassword) : void {
         //On chiffre le mot de passe en clair
         //On met à jour l'attribut "password" de l'utilisateur
     }

     /**
      * Sauvegarde l'image de profil dans le dossier de destination puis affecte son nom au champ correspondant dans la classe de l'utilisateur
      */
     private function sauvegarderPhotoProfil(Utilisateur $utilisateur, ?UploadedFile $fichierPhotoProfil) : void {
         if($fichierPhotoProfil != null) {
             //On configure le nom de l'image à sauvegarder
             //On la déplace vers son dossier de destination
             //On met à jour l'attribut "nomPhotoProfil" de l'utilisateur
         }
     }

     /**
      * Réalise toutes les opérations nécessaires avant l'enregistrement en base d'un nouvel utilisateur, après soumissions du formulaire (hachage du mot de passe, sauvegarde de la photo de profil...)
      */
     public function processNewUtilisateur(Utilisateur $utilisateur, ?string $plainPassword, ?UploadedFile $fichierPhotoProfil) : void {
         //On chiffre le mot de passe
         //On sauvegarde (et on déplace) l'image de profil
     }

 }