<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 10/19/17
 * Time: 12:33 AM
 */

namespace AppBundle\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;

class PhoneTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        if(!$value) return '+48';

        return $value;
    }

    public function reverseTransform($value)
    {
        if(!$value) return null;

        $value = str_replace(['-', ' '], '', $value);

        $plus = substr($value, 0, 1);
        $prefix = substr($value, 1, 2);

        if($plus == '+' && is_numeric($prefix))
        {
            $rest = substr($value, 3, 1);

            if($rest > 0)
            {
                return $value;
            }

            return null;
        }

        return '+48' . $value;
    }
}