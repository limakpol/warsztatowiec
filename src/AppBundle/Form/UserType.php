<?php

namespace AppBundle\Form;


use AppBundle\Entity\User;
use AppBundle\Form\Extension\IconSubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
            ->add('phone1', TextType::class, [
                'label' => 'Telefon',
                'required' => false,
                'attr' => [
                    'maxlength' => 15,
                    'size' => 12,
                ]
            ])
            ->add('phone2', TextType::class, [
                'label' => 'Telefon 2',
                'required' => false,
                'attr' => [
                    'maxlength' => 15,
                    'size' => 12,
                ]
            ])
            ->add('hourly_rate_net', TextType::class, [
                'label' => 'Stawka godzinowa netto',
                'required' => false,
                'attr' => [
                    'maxlength' => 8,
                    'size' => 5,
                ],
            ])
            ->add('address', AddressType::class, [
                'required' => false,
            ])
            ->add('nip', TextType::class, [
                'label' => 'NIP',
                'required' => false,
                'attr' => [
                    'maxlength' => 10,
                    'size' => 12,
                ],
            ])
            ->add('bank_account_number', TextType::class, [
                'label' => 'Nr konta bankowego',
                'required' => false,
                'attr' => [
                    'maxlength' => 26,
                    'size' => 23,
                ],
            ])
            ->add('remarks', TextareaType::class, [
                'label' => 'Uwagi',
                'required' => false,
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