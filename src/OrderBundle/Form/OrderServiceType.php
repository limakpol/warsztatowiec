<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 11/4/17
 * Time: 5:24 AM
 */

namespace OrderBundle\Form;

use AppBundle\Entity\OrderService;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use ServiceBundle\Form\ServiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints\Valid;

class OrderServiceType extends AbstractType
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $vatPc = $workshop->getParameters()->getServiceVatPc();

        $builder
            ->add('service_id', HiddenType::class, [
                'required' => true,
            ])
            ->add('service', ServiceType::class, [
                'required' => true,
                'constraints' => [new Valid()],
            ])
            ->add('unit_price_net', TextType::class, [
                'label' => 'Cena jednostkowa netto [zł]',
                'required' => true,
                'empty_data' => 0.00,
                'data' => '',
                'attr' => [
                    'maxlength' => 10,
                    'class' => 'trade input-unit-price-net',
                ]
            ])
            ->add('quantity', TextType::class, [
                'label' => 'Ilość',
                'required' => true,
                'data' => 1,
                'empty_data' => 1,
                'attr' => [
                    'maxlength' => 10,
                    'class' => 'trade input-quantity',
                ]
            ])
            ->add('total_net_before_discount', TextType::class, [
                'label' => 'Wartość netto przed rabatem [zł]',
                'required' => false,
                'disabled' => true,
                'empty_data' => 0.00,
                'data' => '',
                'attr' => [
                    'maxlength' => 10,
                    'class' => 'trade input-total-net-before-discount',
                ]
            ])
            ->add('discount_pc', TextType::class, [
                'label' => 'Rabat [%]',
                'required' => true,
                'empty_data' => 0.00,
                'data' => 0,
                'attr' => [
                    'maxlength' => 10,
                    'class' => 'trade input-discount-pc',
                ]
            ])
            ->add('discount', TextType::class, [
                'label' => 'Kwota rabatu [zł]',
                'required' => false,
                'disabled' => true,
                'empty_data' => 0.00,
                'data' => '',
                'attr' => [
                    'maxlength' => 10,
                    'class' => 'trade input-discount',
                ]
            ])
            ->add('total_net', TextType::class, [
                'label' => 'Wartość netto [zł]',
                'required' => false,
                'disabled' => true,
                'empty_data' => 0.00,
                'data' => '',
                'attr' => [
                    'maxlength' => 10,
                    'class' => 'trade input-total-net',
                ]
            ])
            ->add('vat_pc', TextType::class, [
                'label' => 'VAT [%]',
                'required' => true,
                'empty_data' => 0.00,
                'data' => $vatPc,
                'attr' => [
                    'maxlength' => 10,
                    'class' => 'trade input-vat-pc',
                ]
            ])
            ->add('vat', TextType::class, [
                'label' => 'Kwota VAT [zł]',
                'required' => false,
                'disabled' => true,
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
                'disabled' => true,
                'empty_data' => 0.00,
                'data' => '',
                'attr' => [
                    'maxlength' => 10,
                    'class' => 'trade input-total-due',
                ]
            ])
            ->add('remarks', TextareaType::class, [
                'label' => 'Uwagi',
                'required' => false,
                'attr' => [
                    'maxlength' => 255,
                ],
            ])
            ->add('workmans', CollectionType::class, [
                'label' => 'Pracownicy',
                'entry_type' => HiddenType::class,
                'entry_options' => ['label' => false,],
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'zapisz',
                'attr' => [
                    'class' => 'btn-save add-i',
                    'data-add-i' => 'floppy-o',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrderService::class,
        ]);
    }
}