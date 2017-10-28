<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 10/28/17
 * Time: 1:10 AM
 */

namespace WarehouseBundle\Form;


use AppBundle\Entity\CarModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class CarModelType extends AbstractType
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
            'data_class' => CarModel::class,
        ]);
    }
}