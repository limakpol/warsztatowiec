<?php

namespace AppBundle\Form;


use AppBundle\Entity\User;
use AppBundle\Form\Transformer\NipTransformer;
use AppBundle\Form\Transformer\NrbTransformer;
use AppBundle\Form\Transformer\PhoneTransformer;
use AppBundle\Form\Transformer\TradeTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

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
                'required' => false,
                'attr' => [
                    'maxlength' => 80,
                    'size' => 30,
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
                'label' => 'Stawka godzinowa netto [zł]',
                'required' => false,
                'attr' => [
                    'maxlength' => 8,
                    'size' => 5,
                ],
            ])
            ->add('address', AddressType::class, [
                'required' => false,
                'constraints' => [new Valid()],
            ])
            ->add('nip', TextType::class, [
                'label' => 'NIP',
                'required' => false,
                'attr' => [
                    'maxlength' => 13,
                    'size' => 12,
                ],
            ])
            ->add('pesel', TextType::class, [
                'label' => 'PESEL',
                'required' => false,
                'attr' => [
                    'maxlength' => 11,
                    'size' => 10,
                ],
            ])
            ->add('bank_account_number', TextType::class, [
                'label' => 'Nr konta bankowego',
                'required' => false,
                'attr' => [
                    'maxlength' => 32,
                    'size' => 23,
                ],
            ])
            ->add('remarks', TextareaType::class, [
                'label' => 'Uwagi',
                'required' => false,
            ])
            ;

            $builder->get('phone1')->addModelTransformer(new PhoneTransformer());
            $builder->get('phone2')->addModelTransformer(new PhoneTransformer());
            $builder->get('nip')->addModelTransformer(new NipTransformer());
            $builder->get('bank_account_number')->addModelTransformer(new NrbTransformer());

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}