<?php

namespace CustomerBundle\Form;

use AppBundle\Entity\Customer;
use AppBundle\Form\AddressType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('forename', TextType::class, [
                'label'     => 'Imię',
                'required'  => false,
                'attr'      => [
                    'maxlength' => 35,
                    'size'      => 20,
                ],
            ])
            ->add('surname', TextType::class, [
                'label'     => 'Nazwisko',
                'required'  => false,
                'attr'      => [
                    'maxlength' => 50,
                    'size'      => 30,
                ],
            ])
            ->add('company_name', TextType::class, [
                'label'     => 'Nazwa firmy',
                'required'  => false,
                'attr'      => [
                    'maxlength' => 50,
                    'size'      => 30,
                ],
            ])
            ->add('nip', TextType::class, [
                'label'     => 'NIP',
                'required'  => false,
                'attr'      => [
                    'maxlength' => 35,
                    'size'      => 20,
                ],
            ])
            ->add('mobile_phone1', TextType::class, [
                'label'     => 'Telefon kom. 1',
                'required'  => false,
                'attr'      => [
                    'maxlength' => 12,
                    'size'      => 10,
                ],
            ])
            ->add('mobile_phone2', TextType::class, [
                'label'     => 'Telefon kom. 2',
                'required'  => false,
                'attr'      => [
                    'maxlength' => 12,
                    'size'      => 10,
                ],
            ])
            ->add('landline_phone', TextType::class, [
                'label'     => 'Telefon stacjonarny',
                'required'  => false,
                'attr'      => [
                    'maxlength' => 9,
                    'size'      => 9,
                ],
            ])
            ->add('contact_person', TextType::class, [
                'label'     => 'Osoba kontaktowa',
                'required'  => false,
                'attr'      => [
                    'maxlength' => 50,
                    'size'      => 20,
                ],
            ])
            ->add('email', EmailType::class, [
                'label'     => 'E-mail',
                'required'  => false,
                'attr'      => [
                    'maxlength' => 80,
                    'size'      => 30,
                ],
            ])
            ->add('address', AddressType::class, [
                'constraints' => [new Valid()]
            ])
            ->add('pesel', TextType::class, [
                'label'     => 'PESEL',
                'required'  => false,
                'attr'      => [
                    'maxlength' => 11,
                    'size'      => 10,
                ],
            ])
            ->add('bank_account_number', TextType::class, [
                'label'     => 'Nr konta bankowego',
                'required'  => false,
                'attr'      => [
                    'maxlength' => 26,
                    'size'      => 24,
                ],
            ])
            ->add('remarks', TextareaType::class, [
                'label'     => 'Uwagi',
                'required'  => false,
                'attr'      => [
                    'maxlength' => 255,
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

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }

}