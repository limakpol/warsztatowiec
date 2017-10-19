<?php

namespace AppBundle\Service\Trade;

interface TradeHeaderInterface
{
    public function setTotalNetBeforeDiscount($tradeValue);
    public function setDiscount($tradeValue);
    public function setTotalNet($tradeValue);
    public function setVat($tradeValue);
    public function setTotalDue($tradeValue);

    public function getTotalNetBeforeDiscount();
    public function getDiscount();
    public function getTotalNet();
    public function getVat();
    public function getTotalDue();
}


