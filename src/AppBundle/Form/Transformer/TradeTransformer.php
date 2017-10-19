<?php

namespace AppBundle\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;

class TradeTransformer implements DataTransformerInterface
{
    public function transform($value)
    {

        return $value;
    }

    public function reverseTransform($value)
    {
        $value = str_replace(',', '.', $value);

        return round($value, 2);
    }
}