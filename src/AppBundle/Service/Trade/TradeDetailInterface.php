<?php


namespace AppBundle\Service\Trade;

interface TradeDetailInterface extends TradeHeaderInterface
{
    public function setUnitPriceNet($tradeValue);
    public function setQuantity($tradeValue);
    public function setDiscountPc($tradeValue);
    public function setVatPc($tradeValue);

    public function getUnitPriceNet();
    public function getQuantity();
    public function getDiscountPc();
    public function getVatPc();

    public function getDeletedAt();
    public function getRemovedAt();

}