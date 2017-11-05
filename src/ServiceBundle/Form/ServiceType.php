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
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ServiceType extends AbstractType
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
                'query_builder' => function(EntityRepository $er) use ($workshop)
                {
                    return $er->createQueryBuilder('m')
                        ->where('m.type_of_quantity = :type')
                        ->andWhere('m.workshop = :workshop')
                        ->andWhere('m.deleted_at IS NULL')
                        ->andWhere('m.removed_at IS NULL')
                        ->setParameters([
                            ':type' => 'service',
                            ':workshop' => $workshop,
                        ])
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