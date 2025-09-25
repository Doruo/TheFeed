<?php

namespace App\Service;

use Symfony\Component\Form\FormInterface;

interface FlashMessageHelperInterface
{
    function addFlash(string $type, string $message) : void;
    function addFormErrorsAsFlash(FormInterface $form) : void;
}