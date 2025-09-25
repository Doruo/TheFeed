<?php
namespace App\Service;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RequestStack;

readonly class FlashMessageHelper implements FlashMessageHelperInterface
{

    public function __construct(private RequestStack $requestStack){}

    // Traitement erreurs
    public function addFormErrorsAsFlash(FormInterface $form) : void
    {
        $flashBag = $this->requestStack->getSession()->getFlashBag();

        $errors = $form->getErrors(true);
        foreach ($errors as $error) {
            $errorMsg = $error->getMessage();
            $flashBag->add("error", $errorMsg);
        }
    }

    public function addFlash(string $type, string $message) : void
    {
        $flashBag = $this->requestStack->getSession()->getFlashBag();
        $flashBag->add($type, $message);

    }
}
