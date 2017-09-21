<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/21/17
 * Time: 3:14 PM
 */

namespace AppBundle\Form\Validator\Constraint;


use AppBundle\Form\Validator\NipValidator;
use Symfony\Component\Validator\Constraint;

class Nip extends Constraint
{
   public $message = 'Wpisany numer NIP jest nieprawidłowy';

   public function validatedBy()
   {
      return NipValidator::class;
   }
}