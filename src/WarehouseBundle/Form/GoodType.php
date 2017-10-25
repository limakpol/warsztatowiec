<?php

namespace WarehouseBundle\Form;

use AppBundle\Entity\Good;
use AppBundle\Entity\Measure;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GoodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nazwa',
                'required' => true,
                'attr' => [
                    'maxlength' => 40,
                    'size' => 30,
                ],
            ])
            ->add('measure', EntityType::class, [
                'label' => 'Jednostka',
                'required' => true,
                'class' => Measure::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('quantity', TextType::class, [
                'label' => 'Ilość',
                'required' => false,
                'empty_data' => 0.00,
                'attr' => [
                    'maxlength' => 10,
                    'class' => 'trade input-quantity',
                ]
            ])
            ->add('remarks', TextareaType::class, [
                'label' => 'Uwagi',
                'required' => false,
                'attr' => [
                    'maxlength' => 255,
                ]
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults([
            'data_class' => Good::class,
        ]);
    }
}