<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/12/17
 * Time: 10:41 AM
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', UserType::class, [

            ])
            ->add('workshop', WorkshopType::class)
            ->add('submit', SubmitType::class, [
                'label' => 'zarejestruj',
                'attr' => [
                    'class' => 'btn-save',
                ],
            ])
            ;
    }
}