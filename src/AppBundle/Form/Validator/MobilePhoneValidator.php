<?php

namespace AppBundle\Form\Validator;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MobilePhoneValidator extends ConstraintValidator
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function validate($value, Constraint $constraint)
    {
        $pattern = '/^\+{1}[0-9]{11}$/';

        if($value && !preg_match($pattern, $value))
        {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}