<?php

namespace VehicleBundle\Form;

use AppBundle\Entity\Vehicle;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class VehicleType extends AbstractType
{
    public $em;
    public $tokenStorage;

    public function __construct(EntityManager $entityManager, TokenStorageInterface $tokenStorage)
    {

        $this->em = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('car_brand', TextType::class, [
                'label'     => 'Marka',
                'required'  => true,
                'mapped'    => false,
                'attr'      => [
                    'maxlength' => 20,
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Pole Marka nie może być puste', 'groups' => ['vehicle']]),
                    new Length(['max' => 20, 'maxMessage' => 'Pole Marka nie może zawierać więcej niż 20 znaków', 'groups' => ['vehicle']]),
                ],
            ])
            ->add('car_model', TextType::class, [
                'label'     => 'Model',
                'required'  => true,
                'mapped'    => false,
                'attr'      => [
                    'maxlength' => 20,
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Pole Model nie może być puste', 'groups' => ['vehicle']]),
                    new Length(['max' => 20, 'maxMessage' => 'Pole Model nie może zawierać więcej niż 20 znaków', 'groups' => ['vehicle']]),
                ],
            ])
            ->add('version', TextType::class, [
                'label'     => 'Wersja',
                'required'  => false,
                'attr'      => [
                    'maxlength' => 15,
                    'size'      => 15,
                ],
            ])
            ->add('registration_number', TextType::class, [
                'label'     => 'Nr rejestracyjny',
                'required'  => false,
                'attr'      => [
                    'maxlength' => 10,
                    'size'      => 10,
                ],
            ])
            ->add('vin', TextType::class, [
                'label'     => 'Numer VIN',
                'required'  => false,
                'attr'      => [
                    'maxlength' => 17,
                    'size'      => 17,
                ],
            ])
            ->add('model_year', TextType::class, [
                'label'     => 'Rok produkcji',
                'required'  => false,
                'attr'      => [
                    'maxlength' => 4,
                    'size'      => 4,
                ],
            ])
            ->add('mileage', TextType::class, [
                'label'     => 'Przebieg [tys. km]',
                'required'  => false,
                'attr'      => [
                    'maxlength' => 3,
                    'size'      => 3,
                    'class'     => 'input-center',
                ],
            ])
            ->add('engine_type', ChoiceType::class, [
                'label' => 'Typ silnika',
                'required' => false,
                'placeholder' => '',
                'choices' => [
                    'benzyna' => 'benzyna',
                    'benzyna + gaz' => 'benzyna + gaz',
                    'diesel'    => 'diesel',
                    'hybryda'  =>'hybryda',
                    'EE'  =>'EE',
                ],
            ])
            ->add('engine_displacement_l', TextType::class, [
                'label' => 'Pojemność silnika [l]',
                'required' => false,
                'data' => '',
                'attr' => [
                    'maxlength' => 5,
                    'size' => 4,
                    'class'     => 'input-center',
                ],
            ])
            ->add('engine_power_km', TextType::class, [
                'label' => 'Moc silnika [KM]',
                'required' => false,
                'data' => '',
                'attr' => [
                    'maxlength' => 4,
                    'size' => 3,
                    'class'     => 'input-center',
                ],
            ])
            ->add('date_of_inspection', DateType::class, [
                'label'     => 'Data najbliższego przeglądu technicznego [dd-mm-rrrr]',
                'required'  => false,
                'widget'    => 'choice',
                'format'    => 'dd-MM-yyyy',
            ])
            ->add('date_of_oil_change', DateType::class, [
                'label' => 'Data wymiany oleju [dd-mm-rrrr]',
                'required' => false,
                'widget'    => 'choice',
                'format'    => 'dd-MM-yyyy',
            ])
            ->add('remarks', TextareaType::class, [
                'label' => 'Uwagi',
                'required' => false,
                'attr' => [
                    'maxlength' => 255,
                    'size' => 20,
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
            'data_class' => Vehicle::class
        ]);
    }

}