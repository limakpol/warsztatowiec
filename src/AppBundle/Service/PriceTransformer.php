<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/25/17
 * Time: 10:53 PM
 */

namespace AppBundle\Service;


use Symfony\Component\Form\DataTransformerInterface;

class PriceTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        $value = str_replace(',', '.', $value);

        return round($value, 2);
    }

    public function reverseTransform($value)
    {
        // TODO: Implement reverseTransform() method.
    }
}