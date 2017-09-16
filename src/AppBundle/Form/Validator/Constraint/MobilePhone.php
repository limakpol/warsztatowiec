<?php


namespace AppBundle\Form\Validator\Constraint;

use AppBundle\Form\Validator\MobilePhoneValidator;
use Symfony\Component\Validator\Constraint;

class MobilePhone extends Constraint
{
    public $message = 'Wpisany numer telefonu jest nieprawidłowy';

    public function validatedBy()
    {
        return MobilePhoneValidator::class;
    }
}
