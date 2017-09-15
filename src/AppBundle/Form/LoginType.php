<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/12/17
 * Time: 10:42 AM
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', UserType::class)
            ->add('submit', SubmitType::class, [
                'label' => 'zaloguj',
                'attr' => [
                    'class' => 'btn-login',
                ],
            ])
            ;
    }

}