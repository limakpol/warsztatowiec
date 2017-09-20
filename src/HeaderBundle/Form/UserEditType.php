<?php

namespace HeaderBundle\Form;

use AppBundle\Form\UserType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/20/17
 * Time: 8:12 PM
 */

class UserEditType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', UserType::class)
            ->add('submit', SubmitType::class, [
                'label' => 'zapisz',
                'attr' => [
                    'class' => 'btn-save add-i',
                    'data-add-i' => 'floppy-o',
                ],
            ])
            ;

    }
}