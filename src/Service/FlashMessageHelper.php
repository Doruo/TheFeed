<?php
namespace App\Service;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class FlashMessageHelper
{

    public function __construct(/* Injection de RequestStack */){}

    public function addFormErrorsAsFlash(FormInterface $form) : void
    {
        $errors = $form->getErrors(true);
        //Ajouts des erreurs du formulaire comme messages flash de la catégorie "error".
    }
}
