<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/12/17
 * Time: 10:22 AM
 */

namespace AppBundle\Form;


use AppBundle\Entity\Address;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('street', TextType::class, [
                'label' => 'Ulica',
                'required' => false,
                'attr' => [
                    'maxlength' => 50,
                    'size' => 30,
                ]
            ])
            ->add('house_number', TextType::class, [
                'label' => 'Nr domu',
                'required' => false,
                'attr' => [
                    'maxlength' => 5,
                    'size' => 5,
                ]
            ])
            ->add('flat_number', TextType::class, [
                'label' => 'Nr mieszkania',
                'required' => false,
                'attr' => [
                    'maxlength' => 5,
                    'size' => 3,
                ]
            ])
            ->add('post_code', TextType::class, [
                'label' => 'Kod pocztowy',
                'required' => false,
                'attr' => [
                    'maxlength' => 6,
                    'size' => 5,
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Miejscowość',
                'required' => false,
                'attr' => [
                    'maxlength' => 50,
                    'size' => 30,
                ]
            ])
            ->add('province', EntityType::class, [
                'label' => 'Województwo',
                'required' => false,
                'class' => 'AppBundle\Entity\Province',
                'choice_label' => 'name',
                'placeholder' => '-- wybierz --',
                'multiple' => false,
                'expanded' => false,
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }

}