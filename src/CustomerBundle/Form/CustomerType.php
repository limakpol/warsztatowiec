<?php

namespace CustomerBundle\Form;

use AppBundle\Entity\Customer;
use AppBundle\Form\AddressType;
use AppBundle\Form\Transformer\PhoneTransformer;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints\Valid;

class CustomerType extends AbstractType
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
            ->add('forename', TextType::class, [
                'label'     => 'Imię',
                'required'  => false,
                'attr'      => [
                    'maxlength' => 35,
                    'size'      => 20,
                ],
            ])
            ->add('surname', TextType::class, [
                'label'     => 'Nazwisko',
                'required'  => false,
                'attr'      => [
                    'maxlength' => 50,
                    'size'      => 30,
                ],
            ])
            ->add('company_name', TextType::class, [
                'label'     => 'Nazwa firmy',
                'required'  => false,
                'attr'      => [
                    'maxlength' => 50,
                    'size'      => 30,
                ],
            ])
            ->add('nip', TextType::class, [
                'label'     => 'NIP',
                'required'  => false,
                'attr'      => [
                    'maxlength' => 35,
                    'size'      => 20,
                ],
            ])
            ->add('mobile_phone1', TextType::class, [
                'label'     => 'Telefon kom. 1',
                'required'  => false,
                'data'      => '+48',
                'attr'      => [
                    'maxlength' => 12,
                    'size'      => 12,
                ],
            ])
            ->add('mobile_phone2', TextType::class, [
                'label'     => 'Telefon kom. 2',
                'required'  => false,
                'data'      => '+48',
                'attr'      => [
                    'maxlength' => 12,
                    'size'      => 12,
                ],
            ])
            ->add('landline_phone', TextType::class, [
                'label'     => 'Telefon stacjonarny',
                'required'  => false,
                'attr'      => [
                    'maxlength' => 9,
                    'size'      => 9,
                ],
            ])
            ->add('contact_person', TextType::class, [
                'label'     => 'Osoba kontaktowa',
                'required'  => false,
                'attr'      => [
                    'maxlength' => 50,
                    'size'      => 20,
                ],
            ])
            ->add('email', EmailType::class, [
                'label'     => 'E-mail',
                'required'  => false,
                'attr'      => [
                    'maxlength' => 80,
                    'size'      => 30,
                ],
            ])
            ->add('address', AddressType::class, [
                'constraints' => [new Valid()]
            ])
            ->add('pesel', TextType::class, [
                'label'     => 'PESEL',
                'required'  => false,
                'attr'      => [
                    'maxlength' => 11,
                    'size'      => 10,
                ],
            ])
            ->add('bank_account_number', TextType::class, [
                'label'     => 'Nr konta bankowego',
                'required'  => false,
                'attr'      => [
                    'maxlength' => 26,
                    'size'      => 24,
                ],
            ])
            ->add('remarks', TextareaType::class, [
                'label'     => 'Uwagi',
                'required'  => false,
                'attr'      => [
                    'maxlength' => 255,
                ],
            ])
            ->add('groupps', CollectionType::class, [
                'label' => 'Należy do grup:',
                'entry_type' => GrouppType::class,
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
            ])
            ;

            $builder->get('mobile_phone1')->addModelTransformer(new PhoneTransformer());
            $builder->get('mobile_phone2')->addModelTransformer(new PhoneTransformer());

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }

}