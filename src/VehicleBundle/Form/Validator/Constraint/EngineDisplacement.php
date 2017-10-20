<?php

namespace VehicleBundle\Form\Validator\Constraint;

use Symfony\Component\Validator\Constraint;
use VehicleBundle\Form\Validator\EngineDisplacementValidator;

class EngineDisplacement extends Constraint
{
    public $message = 'Błędna wartość';

    public function validatedBy()
    {
        return EngineDisplacementValidator::class;
    }
}