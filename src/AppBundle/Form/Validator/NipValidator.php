<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/21/17
 * Time: 3:23 PM
 */

namespace AppBundle\Form\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NipValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if( strlen($value) > 0  && !$this->checkNIP($value))
        {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
    private function checkNIP($str)
    {
        $str = preg_replace("/[^0-9]+/","",$str);
        if (strlen($str) != 10)
        {
            return false;
        }
        $arrSteps = array(6, 5, 7, 2, 3, 4, 5, 6, 7);
        $intSum=0;
        for ($i = 0; $i < 9; $i++)
        {
            $intSum += $arrSteps[$i] * $str[$i];
        }
        $int = $intSum % 11;
        $intControlNr=($int == 10) ? 0 : $int;
        if ($intControlNr == $str[9])
        {
            return true;
        }
        return false;
    }
}