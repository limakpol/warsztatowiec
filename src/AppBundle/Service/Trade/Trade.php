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

    public function normalizeDetail(TradeDetailInterface $tradeDetail)
    {
        $unitPriceNet   = $tradeDetail->getUnitPriceNet();
        $unitPriceNet   = $this->normalize($unitPriceNet);
        $tradeDetail->setUnitPriceNet($unitPriceNet);

        $quantity   = $tradeDetail->getQuantity();
        $quantity   = $this->normalize($quantity);
        $tradeDetail->setQuantity($quantity);

        $totalNetBeforeDiscount = $tradeDetail->getTotalNetBeforeDiscount();
        $totalNetBeforeDiscount = $this->normalize($totalNetBeforeDiscount);
        $tradeDetail->setTotalNetBeforeDiscount($totalNetBeforeDiscount);

        $discountPc = $tradeDetail->getDiscountPc();
        $discountPc = $this->normalize($discountPc);
        $tradeDetail->setDiscount($discountPc);

        $discount = $tradeDetail->getDiscount();
        $discount = $this->normalize($discount);
        $tradeDetail->setDiscount($discount);

        $totalNet = $tradeDetail->getTotalNet();
        $totalNet = $this->normalize($totalNet);
        $tradeDetail->setTotalNet($totalNet);
        
        $vatPc = $tradeDetail->getVatPc();
        $vatPc = $this->normalize($vatPc);
        $tradeDetail->setVat($vatPc);

        $vat = $tradeDetail->getVat();
        $vat = $this->normalize($vat);
        $tradeDetail->setVat($vat);

        $totalDue = $tradeDetail->getTotalDue();
        $totalDue = $this->normalize($totalDue);
        $tradeDetail->setTotalDue($totalDue);

        return $tradeDetail;
    }

    public function evaluateDetail(TradeDetailInterface $tradeDetail)
    {
        $unitPriceNet   = $tradeDetail->getUnitPriceNet();
        $unitPriceNet   = $this->normalize($unitPriceNet);
        $tradeDetail->setUnitPriceNet($unitPriceNet);

        $quantity   = $tradeDetail->getQuantity();
        $quantity   = $this->normalize($quantity);
        $tradeDetail->setQuantity($quantity);

        $totalNetBeforeDiscount = round($unitPriceNet * $quantity, 2);
        $tradeDetail->setTotalNetBeforeDiscount($totalNetBeforeDiscount);
        
        $discountPc = $tradeDetail->getDiscountPc();
        $discountPc = $this->normalize($discountPc);
        $tradeDetail->setDiscountPc($discountPc);

        $discount = round(($discountPc / 100) * $totalNetBeforeDiscount, 2);
        $tradeDetail->setDiscount($discount);

        $totalNet = round($totalNetBeforeDiscount - $discount, 2);
        $tradeDetail->setTotalNet($totalNet);

        $vatPc = $tradeDetail->getVatPc();
        $vatPc = $this->normalize($vatPc);
        $tradeDetail->setVatPc($vatPc);

        $vat = round(($vatPc / 100) * $totalNet , 2);
        $tradeDetail->setVat($vat);

        $totalDue = round($totalNet + $vat, 2);

        $tradeDetail->setTotalDue($totalDue);

        return $tradeDetail;
    }

    public function addDetail(TradeHeaderInterface $tradeHeader, TradeDetailInterface $tradeDetail)
    {
        $totalNetBeforeDiscount = $tradeHeader->getTotalNetBeforeDiscount();
        $totalNetBeforeDiscount += $tradeDetail->getTotalNetBeforeDiscount();
        $tradeHeader->setTotalNetBeforeDiscount($totalNetBeforeDiscount);

        $discount = $tradeHeader->getDiscount();
        $discount += $tradeDetail->getDiscount();
        $tradeHeader->setDiscount($discount);

        $totalNet = $tradeHeader->getTotalNet();
        $totalNet += $tradeDetail->getTotalNet();
        $tradeHeader->setTotalNet($totalNet);

        $vat = $tradeHeader->getVat();
        $vat += $tradeDetail->getVat();
        $tradeHeader->setVat($vat);

        $totalDue = $tradeHeader->getTotalDue();
        $totalDue += $tradeDetail->getTotalDue();
        $tradeHeader->setTotalDue($totalDue);

        return $tradeHeader;
    }

}