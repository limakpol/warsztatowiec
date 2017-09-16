<?php

namespace AppBundle\Form\Validator;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EmailValidator extends ConstraintValidator
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function validate($value, Constraint $constraint)
    {

        $emails = $this->em->getRepository('AppBundle:User')->findBy([
            'deleted_at' => null,
            'email' => $value,
        ]);

        if(count($emails) > 0)
        {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}