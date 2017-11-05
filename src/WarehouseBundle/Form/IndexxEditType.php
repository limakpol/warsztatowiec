<?php

namespace WarehouseBundle\Form;

use AppBundle\Entity\Indexx;
use AppBundle\Entity\Producer;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class IndexxEditType extends AbstractType
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
                'query_builder' => function(EntityRepository $er) use ($workshop)
                {
                    return $er->createQueryBuilder('p')
                        ->where('p.workshop = :workshop')
                        ->andWhere('p.deleted_at IS NULL')
                        ->andWhere('p.removed_at IS NULL')
                        ->setParameters([
                            ':workshop' => $workshop,
                        ])
                        ;
                }
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