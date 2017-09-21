<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/21/17
 * Time: 6:11 PM
 */

namespace AppBundle\Form\Validator\Constraint;

use AppBundle\Form\Validator\PasswordValidator;
use Symfony\Component\Validator\Constraint;

class Password extends Constraint
{
    public $messageNotBlank = 'Hasło nie może być puste';
    public $messageMin      = 'Hasło musi zawierać co najmniej 6 znaków';
    public $messageMaz      = 'Hasło może zawierać co najwyżej 20 znaków';
    public $messageRegex    = 'Hasło może zawierać małe i duże litery, cyfry i znaki specjalne';

    public function validatedBy()
    {
        return PasswordValidator::class;
    }
}