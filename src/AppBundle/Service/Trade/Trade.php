<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 10/18/17
 * Time: 3:25 AM
 */

namespace AppBundle\Service\Trade;

use AppBundle\Entity\OrderAction;
use AppBundle\Entity\OrderHeader;
use AppBundle\Entity\OrderIndexx;
use AppBundle\Entity\OrderService;
use AppBundle\Service\Trade\TradeHeaderInterface;
use Doctrine\Common\Collections\Collection;

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

    public function evaluateHeader(TradeHeaderInterface $tradeHeader, $detailSet = [])
    {
        $totalNetBeforeDiscount = 0;
        $discount = 0;
        $totalNet = 0;
        $vat      = 0;
        $totalDue = 0;

        /** @var TradeDetailInterface $detail */
        foreach($detailSet as $details)
        {
            foreach ($details as $detail)
            {
                if (null === $detail->getDeletedAt() && null === $detail->getRemovedAt())
                {
                    $totalNetBeforeDiscount += $detail->getTotalNetBeforeDiscount();
                    $discount += $detail->getDiscount();
                    $totalNet += $detail->getTotalNet();
                    $vat += $detail->getVat();
                    $totalDue += $detail->getTotalDue();
                }
            }
        }

        $tradeHeader->setTotalNetBeforeDiscount($totalNetBeforeDiscount);
        $tradeHeader->setDiscount($discount);
        $tradeHeader->setTotalNet($totalNet);
        $tradeHeader->setVat($vat);
        $tradeHeader->setTotalDue($totalDue);

        return $tradeHeader;
    }

    public function evaluateOrderHeader(OrderHeader $orderHeader)
    {
        $totalNetBeforeDiscount = 0;
        $discount = 0;
        $totalNet = 0;
        $vat      = 0;
        $totalDue = 0;

        /** @var OrderIndexx $orderIndexx */
        foreach($orderHeader->getOrderIndexxes() as $orderIndexx)
        {
            if (null === $orderIndexx->getDeletedAt() && null === $orderIndexx->getRemovedAt())
            {
                $totalNetBeforeDiscount += $orderIndexx->getTotalNetBeforeDiscount();
                $discount += $orderIndexx->getDiscount();
                $totalNet += $orderIndexx->getTotalNet();
                $vat += $orderIndexx->getVat();
                $totalDue += $orderIndexx->getTotalDue();
            }

            /** @var OrderAction $orderAction */
            foreach($orderIndexx->getOrderActions() as $orderAction)
            {
                if (null === $orderAction->getDeletedAt() && null === $orderAction->getRemovedAt())
                {
                    $totalNetBeforeDiscount += $orderAction->getTotalNetBeforeDiscount();
                    $discount += $orderAction->getDiscount();
                    $totalNet += $orderAction->getTotalNet();
                    $vat += $orderAction->getVat();
                    $totalDue += $orderAction->getTotalDue();
                }   
            }
        }

        /** @var OrderService $orderService */
        foreach($orderHeader->getOrderServices() as $orderService)
        {
            if (null === $orderService->getDeletedAt() && null === $orderService->getRemovedAt())
            {
                $totalNetBeforeDiscount += $orderService->getTotalNetBeforeDiscount();
                $discount += $orderService->getDiscount();
                $totalNet += $orderService->getTotalNet();
                $vat += $orderService->getVat();
                $totalDue += $orderService->getTotalDue();
            }
        }

        $orderHeader->setTotalNetBeforeDiscount($totalNetBeforeDiscount);
        $orderHeader->setDiscount($discount);
        $orderHeader->setTotalNet($totalNet);
        $orderHeader->setVat($vat);
        $orderHeader->setTotalDue($totalDue);

        return $orderHeader;
    }


}