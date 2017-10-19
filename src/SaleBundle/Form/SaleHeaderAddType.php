<?php

namespace SaleBundle\Form;

use AppBundle\Entity\SaleHeader;
use CustomerBundle\Form\CustomerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class SaleHeaderAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('customer_id', HiddenType::class, [
                'required' => true,
                'empty_data' => null,
            ])
            ->add('customer', CustomerType::class, [
                'required' => false,
                'constraints' => [new Valid()],
            ])
            ->add('document_type', ChoiceType::class, [
                'label' => 'Rodzaj dokumentu',
                'required' => false,
                'placeholder' => '',
                'choices' => [
                    'wydanie z magazynu'    => 'wydanie z magazynu',
                    'asygnata'  =>'asygnata',
                ],
            ])
            ->add('document_number', TextType::class, [
                'label' => 'Numer dokumentu',
                'required' => false,
                'attr' => [
                    'maxlength' => 100,
                ],
            ])
            ->add('remarks', TextareaType::class, [
                'label' => 'Uwagi',
                'required' => false,
                'attr' => [
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
            'data_class' => SaleHeader::class,
        ]);
    }
}