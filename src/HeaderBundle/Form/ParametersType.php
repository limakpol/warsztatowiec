<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/22/17
 * Time: 9:30 PM
 */

namespace HeaderBundle\Form;


use AppBundle\Entity\Parameters;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParametersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('good_margin_pc', IntegerType::class, [
                'label' => 'Marża [%]',
                'scale' => 0,
                'required' => true,
                'attr' => [
                    'maxlength' => 3,
                    'size'      => 2,
                    'max'       => 100,
                    'min'       => 0,
                    'step'      => 1,
                ],
            ])
            ->add('good_vat_pc', IntegerType::class, [
                'label' => 'VAT na towary [%]',
                'required' => true,
                'attr' => [
                    'maxlength' => 3,
                    'size'      => 2,
                    'max'       => 100,
                    'min'       => 0,
                    'step'      => 1,
                ],
            ])
            ->add('service_vat_pc', IntegerType::class, [
                'label' => 'VAT na usługi [%]',
                'required' => true,
                'attr' => [
                    'maxlength' => 3,
                    'size'      => 2,
                    'max'       => 100,
                    'min'       => 0,
                    'step'      => 1,
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
            'data_class' => Parameters::class,
        ]);
    }
}