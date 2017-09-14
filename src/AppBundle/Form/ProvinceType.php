<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/12/17
 * Time: 10:34 AM
 */

namespace AppBundle\Form;


use AppBundle\Entity\Province;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProvinceType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', EntityType::class, [
                'label' => 'Województwo',
                'class' => Province::class,
                'required' => false,
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Province::class,
        ]);
    }
}