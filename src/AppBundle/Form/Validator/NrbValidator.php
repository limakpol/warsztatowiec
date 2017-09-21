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

class NrbValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if( strlen($value) > 0  && !$this->checkNRB($value))
        {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
    private function checkNRB($p_iNRB)
    {
        // Usuniecie spacji
        $iNRB = str_replace(' ', '', $p_iNRB);
        // Sprawdzenie czy przekazany numer zawiera 26 znaków
        if(strlen($iNRB) != 26)
            return false;
        // Zdefiniowanie tablicy z wagami poszczególnych cyfr
        $aWagiCyfr = array(1, 10, 3, 30, 9, 90, 27, 76, 81, 34, 49, 5, 50, 15, 53, 45, 62, 38, 89, 17, 73, 51, 25, 56, 75, 71, 31, 19, 93, 57);
        // Dodanie kodu kraju (w tym przypadku dodajemy kod PL)
        $iNRB = $iNRB.'2521';
        $iNRB = substr($iNRB, 2).substr($iNRB, 0, 2);
        // Wyzerowanie zmiennej
        $iSumaCyfr = 0;
        // Pćtla obliczająca sumć cyfr w numerze konta
        for($i = 0; $i < 30; $i++)
            $iSumaCyfr += $iNRB[29-$i] * $aWagiCyfr[$i];
        // Sprawdzenie czy modulo z sumy wag poszczegolnych cyfr jest rowne 1
        return ($iSumaCyfr % 97 == 1);
    }
}