<?php

namespace WarehouseBundle\Form;

use AppBundle\Entity\Good;
use AppBundle\Entity\Indexx;
use AppBundle\Entity\Producer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class IndexxEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nazwa',
                'required' => true,
                'attr' => [
                    'maxlength' => 30,
                    'size' => 20,
                ],
            ])
            ->add('producer', EntityType::class, [
                'label' => 'Producent',
                'required' => true,
                'class' => Producer::class,
                'choice_label' => 'name',
                'placeholder' => '-- wybierz --',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('quantity', TextType::class, [
                'label' => 'Ilość w magazynie',
                'required' => false,
                'attr' => [
                    'maxlength' => 10,
                    'class' => 'trade',
                ]
            ])
            ->add('unit_price_net', TextType::class, [
                'label' => 'Cena jednostkowa netto [zł]',
                'required' => false,
                'attr' => [
                    'maxlength' => 10,
                    'class' => 'trade',
                ]
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
            'data_class' => Indexx::class,
        ]);
    }
}