<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/21/17
 * Time: 3:14 PM
 */

namespace AppBundle\Form\Validator\Constraint;


use AppBundle\Form\Validator\NrbValidator;
use Symfony\Component\Validator\Constraint;

class Nrb extends Constraint
{
    public $message = 'Wpisany numer konta bankowego jest nieprawidłowy';

    public function validatedBy()
    {
        return NrbValidator::class;
    }
}