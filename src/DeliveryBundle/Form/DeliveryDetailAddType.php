<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 10/24/17
 * Time: 7:38 PM
 */

namespace DeliveryBundle\Form;


use AppBundle\Entity\DeliveryDetail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WarehouseBundle\Form\IndexxType;

class DeliveryDetailAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('indexx', IndexxType::class, [
                'required' => true,
            ])
            ->add('unit_price_net', TextType::class, [
                'label' => 'Cena jednostkowa netto [zł]',
                'required' => true,
                'empty_data' => 0.00,
                'attr' => [
                    'maxlength' => 10,
                    'class' => 'trade input-unit-price-net',
                ]
            ])
            ->add('quantity', TextType::class, [
                'label' => 'Ilość',
                'required' => true,
                'empty_data' => 0.00,
                'attr' => [
                    'maxlength' => 10,
                    'class' => 'trade input-quantity',
                ]
            ])
            ->add('total_net_before_discount', TextType::class, [
                'label' => 'Wartość netto przed rabatem [zł]',
                'required' => false,
                'empty_data' => 0.00,
                'attr' => [
                    'maxlength' => 10,
                    'class' => 'trade input-total-net-before-discount',
                ]
            ])
            ->add('discount_pc', TextType::class, [
                'label' => 'Rabat [%]',
                'required' => true,
                'empty_data' => 0.00,
                'attr' => [
                    'maxlength' => 10,
                    'class' => 'trade input-discount-pc',
                ]
            ])
            ->add('discount', TextType::class, [
                'label' => 'Kwota rabatu [zł]',
                'required' => false,
                'empty_data' => 0.00,
                'attr' => [
                    'maxlength' => 10,
                    'class' => 'trade input-discount',
                ]
            ])
            ->add('total_net', TextType::class, [
                'label' => 'Wartość netto [zł]',
                'required' => false,
                'empty_data' => 0.00,
                'attr' => [
                    'maxlength' => 10,
                    'class' => 'trade input-total-net',
                ]
            ])
            ->add('vat_pc', TextType::class, [
                'label' => 'VAT [%]',
                'required' => true,
                'empty_data' => 0.00,
                'attr' => [
                    'maxlength' => 10,
                    'class' => 'trade input-vat-pc',
                ]
            ])
            ->add('vat', TextType::class, [
                'label' => 'Kwota VAT [zł]',
                'required' => false,
                'empty_data' => 0.00,
                'attr' => [
                    'maxlength' => 10,
                    'class' => 'trade input-vat',
                ]
            ])
            ->add('total_due', TextType::class, [
                'label' => 'Należność całkowita [z]',
                'required' => false,
                'empty_data' => 0.00,
                'attr' => [
                    'maxlength' => 10,
                    'class' => 'trade input-total-due',
                ]
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
           'data_class' => DeliveryDetail::class,
        ]);
    }

}