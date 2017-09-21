<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/21/17
 * Time: 3:27 PM
 */

namespace AppBundle\Form\Validator\Constraint;


use AppBundle\Form\Validator\PostCodeValidator;
use Symfony\Component\Validator\Constraint;

class PostCode extends Constraint
{
    public $message = 'Wpisany kod pocztowy jest nieprawidłowy';

    public function validatedBy()
    {
        return PostCodeValidator::class;
    }
}