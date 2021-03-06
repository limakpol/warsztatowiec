<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/28/17
 * Time: 5:16 PM
 */

namespace CustomerBundle\Form;


use AppBundle\Entity\Groupp;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class GrouppType extends AbstractType
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
           'data_class' => Groupp::class,
        ]);
    }
}