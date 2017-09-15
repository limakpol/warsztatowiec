<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/12/17
 * Time: 10:20 AM
 */

namespace AppBundle\Form;


use AppBundle\Entity\Workshop;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkshopType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name', TextType::class, [
                'label' => 'Nazwa Warsztatu',
                'required' => true,
                'attr' => [
                    'maxlength' => 80,
                    'size' => 35,
                ],
            ])
            ->add('address', AddressType::class)
            ->add('phone', TextType::class, [
                'label' => 'Telefon',
                'required' => false,
                'attr' => [
                    'maxlength' => 12,
                    'size' => 12,
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-mail',
                'required' => true,
                'attr' => [
                    'maxlength' => 80,
                    'size' => 30,
                ],
            ])
            ->add('nip', TextType::class, [
                'label' => 'NIP',
                'required' => false,
                'attr' => [
                    'maxlength' => 10,
                    'size' => 8,
                ],
            ])
            ->add('bank_account_number', TextType::class, [
                'label' => 'Nr konta bankowego',
                'required' => false,
                'attr' => [
                    'maxlength' => 26,
                    'size' => 24,
                ],
            ])
            ->add('website', TextType::class, [
                'label' => 'Strona www',
                'required' => false,
                'attr' => [
                    'maxlength' => 50,
                    'size' => 30,
                ],
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Workshop::class,
        ]);
    }
}