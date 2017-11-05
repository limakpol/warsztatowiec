<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/22/17
 * Time: 7:48 PM
 */

namespace HeaderBundle\Form;

use AppBundle\Form\WorkshopType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class WorkshopEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('workshop', WorkshopType::class)
            ->add('submit', SubmitType::class, [
                'label' => 'zapisz',
                'attr' => [
                    'class' => 'btn-save add-i',
                    'data-add-i' => 'floppy-o',
                ],
            ])
        ;
    }
}