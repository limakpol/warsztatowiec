<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/21/17
 * Time: 6:14 PM
 */

namespace AppBundle\Form\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PasswordValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {
        if($value == '')
        {
            $this->buildViolation($constraint->messageNotBlank);
        }
        elseif(strlen($value) < 6)
        {
            $this->buildViolation($constraint->messageMin);
        }
        elseif(strlen($value) > 20)
        {
            $this->buildViolation($constraint->messageMax);
        }

        $pattern = '/^([A-z]|\d|[@#$%^&*()]){6,20}$/D';

        if(!preg_match($pattern, $value))
        {
            $this->buildViolation($constraint->messageRegex);
        }
    }

    private function buildViolation($message)
    {
        $this->context->buildViolation($message)
            ->addViolation();
    }
}