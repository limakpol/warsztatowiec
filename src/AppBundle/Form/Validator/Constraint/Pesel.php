<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/21/17
 * Time: 3:14 PM
 */

namespace AppBundle\Form\Validator\Constraint;


use AppBundle\Form\Validator\PeselValidator;
use Symfony\Component\Validator\Constraint;

class Pesel extends Constraint
{
    public $message = 'Wpisany numer PESEL jest nieprawidłowy';

    public function validatedBy()
    {
        return PeselValidator::class;
    }
}