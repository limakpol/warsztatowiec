<?php

namespace WarehouseBundle\Form;

use AppBundle\Entity\CarModel;
use AppBundle\Entity\Category;
use AppBundle\Entity\Good;
use AppBundle\Entity\Measure;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
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
                'choice_attr' => function($val, $key, $index)
                {
                  return ['data-shortcut' => $val->getShortcut()];
                },
                'multiple' => false,
                'expanded' => false,
                'query_builder' => function(EntityRepository $er)
                {
                    return $er->createQueryBuilder('m')
                        ->where('m.type_of_quantity = :type')
                        ->setParameter(':type', 'good')
                        ;
                }
            ])
            ->add('quantity', TextType::class, [
                'label' => 'Ilość całkowita w magazynie',
                'required' => false,
                'empty_data' => 0.00,
                'disabled' => true,
                'attr' => [
                    'maxlength' => 10,
                    'class' => 'trade',
                ]
            ])
            ->add('categories', CollectionType::class, [
                'label' => 'Kategorie',
                'entry_type' => HiddenType::class,
                'entry_options' => ['label' => false,],
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('car_models', CollectionType::class, [
                'label' => 'Modele samochodów',
                'entry_type' => HiddenType::class,
                'entry_options' => ['label' => false,],
                'allow_add' => true,
                'allow_delete' => true,
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