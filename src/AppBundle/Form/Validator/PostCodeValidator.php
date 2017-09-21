<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/21/17
 * Time: 3:28 PM
 */

namespace AppBundle\Form\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PostCodeValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {
        $pattern = '/^\d{2}-\d{3}$/D';

        if(strlen($value) > 0 && !preg_match($pattern, $value))
        {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}