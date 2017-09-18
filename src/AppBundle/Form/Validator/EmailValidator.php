<?php

namespace AppBundle\Form\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EmailValidator extends ConstraintValidator
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function validate($value, Constraint $constraint)
    {

        $emails = $this->em->getRepository('AppBundle:User')->findBy([
            'removed_at' => null,
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