<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 10/18/17
 * Time: 3:25 AM
 */

namespace AppBundle\Service\Trade;

use AppBundle\Service\Trade\TradeHeaderInterface;

class Trade
{

    public function normalize($value, $null = false)
    {

        if($null && !$value)
        {
            return $value;
        }

        $value = str_replace(',', '.', $value);

        return round($value, 2);
    }

    public function normalizeHeader(TradeHeaderInterface $tradeHeader)
    {
        $totalNetBeforeDiscount = $tradeHeader->getTotalNetBeforeDiscount();
        $totalNetBeforeDiscount = $this->normalize($totalNetBeforeDiscount);
        $tradeHeader->setTotalNetBeforeDiscount($totalNetBeforeDiscount);

        $discount = $tradeHeader->getDiscount();
        $discount = $this->normalize($discount);
        $tradeHeader->setDiscount($discount);

        $totalNet = $tradeHeader->getTotalNet();
        $totalNet = $this->normalize($totalNet);
        $tradeHeader->setTotalNet($totalNet);

        $vat = $tradeHeader->getVat();
        $vat = $this->normalize($vat);
        $tradeHeader->setVat($vat);

        $totalDue = $tradeHeader->getTotalDue();
        $totalDue = $this->normalize($totalDue);
        $tradeHeader->setTotalDue($totalDue);

        return $tradeHeader;
    }

}