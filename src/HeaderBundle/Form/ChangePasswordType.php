<?php

namespace HeaderBundle\Form;

use AppBundle\Form\Validator\Constraint\OldPassword;
use AppBundle\Form\Validator\Constraint\Password;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            $builder
                ->add('current_password', PasswordType::class, [
                    'label' => 'Aktualne hasło',
                    'required' => true,
                    'attr' => [
                        'maxlength' => 20,
                        'size' => 15,
                    ],
                ])
                ->add('new_password', PasswordType::class, [
                    'label' => 'Nowe hasło',
                    'required' => true,
                    'attr' => [
                        'maxlength' => 20,
                        'size' => 15,
                    ],
                    'constraints' => [new Password()],
                ])
                ->add('new_password_repeat', PasswordType::class, [
                    'label' => 'Powtórz nowe hasło',
                    'required' => true,
                    'attr' => [
                        'maxlength' => 20,
                        'size' => 15,
                    ],
                ])
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