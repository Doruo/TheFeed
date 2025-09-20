<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
 use Symfony\Component\Validator\Constraints\File;
 use Symfony\Component\Validator\Constraints\Length;
 use Symfony\Component\Validator\Constraints\NotBlank;
 use Symfony\Component\Validator\Constraints\NotNull;
 use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('login',TextType::class)
            ->add('plainPassword',PasswordType::class, 
            [
                "mapped" => false,
                "constraints" => [
                    new NotBlank(),
                    new NotNull(),
                    new Length(min:8, max:30, minMessage:"Il faut au moins 8 caractères!",maxMessage:"Il faut moins de 30 caractères!"),
                    new Regex(pattern : '#^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d\w\W]{8,30}$#', 
                    message : 'Format non respecté'),

                ]
            ])
            ->add('adresseEmail',EmailType::class)
            ->add('fichierPhotoProfil', FileType::class,[
                "mapped"=> false,
                "constraints" => [
                    new File(maxSize:"10",maxSizeMessage:"Taille de fichier 10Mo dépassée.",extensions:["jpg","png"],extensionsMessage:"Format de fichier doit etre jpg ou png."),
                ],
            ])
            ->add('inscription',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
