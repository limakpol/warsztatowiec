<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 10/18/17
 * Time: 1:04 AM
 */

namespace AppBundle\Form\Validator\Constraint;


use AppBundle\Form\Validator\TradeValidator;
use Symfony\Component\Validator\Constraint;

class Trade extends Constraint
{
    public $message = 'Wpisano błędną wartość';

    public function validatedBy()
    {
        return TradeValidator::class;
    }
}
