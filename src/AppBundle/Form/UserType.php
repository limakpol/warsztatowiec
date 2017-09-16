<?php

namespace AppBundle\Form;


use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('forename', TextType::class, [
                'label' => 'Imię',
                'required' => true,
                'attr' => [
                    'maxlength' => 30,
                    'size' => 15,
                ],
            ])
            ->add('surname', TextType::class, [
                'label' => 'Nazwisko',
                'required' => true,
                'attr' => [
                    'maxlength' => 50,
                    'size' => 25,
                ],
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Hasło',
                'required' => true,
                'attr' => [
                    'maxlength' => 15,
                    'size' => 10,
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-mail',
                'required' => true,
                'attr' => [
                    'maxlength' => 80,
                    'size' => 25,
                ],
            ])
            ->add('mobile_phone', TextType::class, [
                'label' => 'Numer telefonu',
                'required' => false,
                'attr' => [
                    'maxlength' => 15,
                    'size' => 12,
                ]
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}