<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 10/18/17
 * Time: 1:05 AM
 */

namespace AppBundle\Form\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TradeValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {
        $pattern = '/^\d{1,7}(\,|\.)?\d*$/D';

        if(strlen($value) > 0 && !preg_match($pattern, $value))
        {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}