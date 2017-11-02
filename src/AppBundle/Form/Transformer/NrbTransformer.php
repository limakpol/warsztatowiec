<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 11/2/17
 * Time: 2:35 AM
 */

namespace AppBundle\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;

class NrbTransformer implements DataTransformerInterface
{
    public function transform($value)
    {

        return $value;
    }

    public function reverseTransform($value)
    {
        if(!$value) return null;

        return str_replace(' ', '', $value);
    }
}