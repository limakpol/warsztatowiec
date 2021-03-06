<?php

namespace OrderBundle\Form;

use AppBundle\Entity\OrderHeader;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use AppBundle\Entity\Workstation;
use CustomerBundle\Form\CustomerType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints\Valid;
use VehicleBundle\Form\VehicleType;

class OrderHeaderAddType extends AbstractType
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

        $builder
            ->add('customer_id', HiddenType::class, [
                'required' => true,
                'empty_data' => null,
            ])
            ->add('vehicle_id', HiddenType::class, [
                'required' => true,
                'empty_data' => null,
            ])
            ->add('customer', CustomerType::class, [
                'required' => true,
                'constraints' => [new Valid()],
            ])
            ->add('vehicle', VehicleType::class, [
                'required' => true,
                'constraints' => [new Valid()],
            ])
            ->add('symptoms', CollectionType::class, [
                'label' => 'Objawy zgłaszane przez klienta',
                'entry_type' => SymptomType::class,
                'entry_options' => ['label' => false,],
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('workstation', EntityType::class, [
                'label' => 'Stanowisko naprawcze',
                'required' => false,
                'class' => Workstation::class,
                'choice_label' => 'name',
                'placeholder' => '-- wybierz --',
                'multiple' => false,
                'expanded' => false,
                'query_builder' => function(EntityRepository $er) use ($workshop)
                {
                    return $er->createQueryBuilder('w')
                        ->where('w.workshop = :workshop')
                        ->andWhere('w.deleted_at IS NULL')
                        ->andWhere('w.removed_at IS NULL')
                        ->setParameters([
                            ':workshop' => $workshop,
                        ])
                        ;
                }
            ])
            ->add('priority', CheckboxType::class, [
                'label' => 'Priorytet',
                'required' => false,
            ])
            ->add('remarks', TextareaType::class, [
                'label'     => 'Uwagi',
                'required'  => false,
                'attr'      => [
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
            'data_class' => OrderHeader::class,
        ]);
    }
}