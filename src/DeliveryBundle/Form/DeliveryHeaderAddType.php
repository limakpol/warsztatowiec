<?php

namespace DeliveryBundle\Form;

use AppBundle\Entity\DeliveryHeader;
use CustomerBundle\Form\CustomerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class DeliveryHeaderAddType extends AbstractType
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
            ->add('total_net_before_discount', TextType::class, [
                'label' => 'Wartość całkowita netto przed rabatem [zł]',
                'required' => false,
                'empty_data' => 0.00,
                'data' => '',
                'attr' => [
                    'maxlength' => 10,
                    'class' => 'trade input-total-net-before-discount',
                ],
            ])
            ->add('discount', TextType::class, [
                'label' => 'Suma rabatu [zł]',
                'required' => false,
                'empty_data' => 0.00,
                'data' => '',
                'attr' => [
                    'maxlength' => 10,
                    'class' => 'trade input-discount',
                ],
            ])
            ->add('total_net', TextType::class, [
                'label' => 'Wartość całkowita netto [zł]',
                'required' => false,
                'empty_data' => 0.00,
                'data' => '',
                'attr' => [
                    'maxlength' => 10,
                    'class' => 'trade input-total-net',
                ]
            ])
            ->add('vat', TextType::class, [
                'label' => 'Suma VAT [zł]',
                'required' => false,
                'empty_data' => 0.00,
                'data' => '',
                'attr' => [
                    'maxlength' => 10,
                    'class' => 'trade input-vat',
                ]
            ])
            ->add('total_due', TextType::class, [
                'label' => 'Należność całkowita [zł]',
                'required' => false,
                'empty_data' => 0.00,
                'data' => '',
                'attr' => [
                    'maxlength' => 10,
                    'class' => 'trade input-total-due',
                ]
            ])
            ->add('document_type', ChoiceType::class, [
                'label' => 'Rodzaj dokumentu',
                'required' => false,
                'placeholder' => '',
                'choices' => [
                    'faktura' => 'faktura',
                    'paragon' => 'paragon',
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
            ->add('autocomplete', CheckboxType::class, [
                'label' => 'Uzupełnij dane automatycznie',
                'required' => false,
                'attr' => [
                    'class' => 'trade-autocomplete',
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
            'data_class' => DeliveryHeader::class,
        ]);
    }
}