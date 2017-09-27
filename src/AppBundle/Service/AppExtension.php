<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/27/17
 * Time: 5:10 AM
 */

namespace AppBundle\Service;


class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('cast_to_array', [$this, 'castToArrayFilter']),
            new \Twig_SimpleFilter('phone', [$this, 'phoneFilter']),
            new \Twig_SimpleFilter('date', [$this, 'dateFilter']),
            new \Twig_SimpleFilter('bool', [$this, 'boolFilter']),
            new \Twig_SimpleFilter('money', [$this, 'moneyFilter']),
        ];
    }

    public function castToArrayFilter($stdClassObject)
    {
        return (array) $stdClassObject;
    }

    public function phoneFilter($phoneNumber)
    {
        $phoneNumber = chunk_split($phoneNumber, 3, '&');

        $phoneNumber = explode('&', $phoneNumber);

        $phoneNumber[1] = $phoneNumber[0] . ' ' . $phoneNumber[1];

        unset($phoneNumber[0]);
        unset($phoneNumber[4]);

        return implode('-', $phoneNumber);
    }

    public function dateFilter($date, $hour = true)
    {
        if(!$date) return '';

        if($date instanceof \DateTime)
        {
            if($hour == false) return $date->format('d.m.Y\r\.');

            return $date->format('d.m.Y\r\. \g\.H:i');
        }
        else
        {
            $date = \DateTime::createFromFormat('Y-m-d H:i:s', $date);

            if($hour == false) return $date->format('d.m.Y\r\.');

            return $date ? $date->format('d.m.Y\r\. \g\.H:i') : '';
        }
    }
    public function boolFilter($int, $no = false)
    {
        if($int)
        {
            return 'TAK';
        }
        else
        {
            if($no) return 'NIE';
            else return null;
        }
    }

    public function moneyFilter($float)
    {
        return number_format($float, 2, '.', ' ');
    }

    public function getName()
    {
        return 'app_extension';
    }
}