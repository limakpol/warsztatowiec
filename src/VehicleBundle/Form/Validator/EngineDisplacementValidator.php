<?php

namespace VehicleBundle\Form\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EngineDisplacementValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if($value && $value < 0.5 || $value > 20)
        {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}