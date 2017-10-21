<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 10/20/17
 * Time: 2:29 PM
 */

namespace OrderBundle\Form;


use AppBundle\Entity\OrderSymptom;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class SymptomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', HiddenType::class, [
                'required' => true,
                'constraints' => [new Valid()],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrderSymptom::class,
        ]);
    }
}