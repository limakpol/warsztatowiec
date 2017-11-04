<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 11/4/17
 * Time: 5:16 AM
 */

namespace ServiceBundle\Form;


use AppBundle\Entity\Measure;
use AppBundle\Entity\Service;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nazwa',
                'required' => true,
                'attr' => [
                    'maxlength' => 50,
                    'size' => 40,
                ],
            ])
            ->add('measure', EntityType::class, [
                'label' => 'Jednostka',
                'placeholder' => '',
                'required' => false,
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
                        ->setParameter(':type', 'service')
                        ;
                }
            ])
            ->add('unit_price_net', TextType::class, [
                'label' => 'Cena jednostkowa netto [zł]',
                'required' => false,
                'attr' => [
                    'maxlength' => 10,
                    'class' => 'trade',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}