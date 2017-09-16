<?php

namespace AppBundle\Form\Validator\Constraint;

use AppBundle\Form\Validator\EmailValidator;
use Symfony\Component\Validator\Constraint;

class Email extends Constraint
{
    public $message = 'Wpisany adres e-mail już istnieje';

    public function validatedBy()
    {
        return EmailValidator::class;
    }
}
