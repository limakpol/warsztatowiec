<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 10/25/17
 * Time: 1:48 PM
 */

namespace SaleBundle\Service\Helper;

use AppBundle\Entity\IndexxEdit;
use AppBundle\Entity\SaleDetail;
use AppBundle\Entity\SaleHeader;
use AppBundle\Entity\Good;
use AppBundle\Entity\Indexx;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use AppBundle\Service\Trade\Trade;
use AppBundle\Service\Trade\TradeDetailInterface;
use AppBundle\Service\Trade\TradeHeaderInterface;
use Doctrine\Common\Collections\Collection;
use SaleBundle\Form\SaleDetailAddType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use WarehouseBundle\Service\Helper\GoodHelper;
use WarehouseBundle\Service\Helper\IndexxHelper;

class SaleDetailAddHelper
{
    private $requestStack;
    private $tokenStorage;
    private $entityManager;
    private $formFactory;
    private $goodHelper;
    private $indexxHelper;
    private $trade;

    public function __construct(RequestStack $requestStack, TokenStorageInterface $tokenStorage, EntityManager $entityManager, FormFactoryInterface $formFactory, GoodHelper $goodHelper, IndexxHelper $indexxHelper, Trade $trade)
    {
        $this->requestStack     = $requestStack;
        $this->tokenStorage     = $tokenStorage;
        $this->entityManager    = $entityManager;
        $this->formFactory      = $formFactory;
        $this->goodHelper       = $goodHelper;
        $this->indexxHelper     = $indexxHelper;
        $this->trade            = $trade;
    }

    public function write(Form $form, SaleHeader $saleHeader, $prevGood, $prevIndexxQty)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var SaleDetail $saleDetail */
        $saleDetail = $form->getData();

        $dateTime = new \DateTime();

        $saleDetail->setSaleHeader($saleHeader);
        $saleHeader->addSaleDetail($saleDetail);
        $saleDetail->setCreatedAt($dateTime);
        $saleDetail->setCreatedBy($user);
        $saleDetail->setUpdatedBy($user);

        $indexx = $saleDetail->getIndexx();
        $good   = $indexx->getGood();

        $saleDetail = $this->trade->evaluateDetail($saleDetail);
        $saleDetail = $this->setIndexxUnitPriceNet($saleDetail);
        $saleDetail = $this->setQuantity($saleDetail, $prevGood, $prevIndexxQty);

        $saleHeader = $this->evaluateHeader($saleHeader, $saleHeader->getSaleDetails());

        $good = $this->goodHelper->assignCategories($good);
        $good = $this->goodHelper->assignCarModels($good);

        $em->persist($good);
        $em->persist($indexx);
        $em->persist($saleDetail);
        $em->persist($saleHeader);

        $em->flush();

        return true;
    }

    public function getGoodSortableParameters()
    {
        $goodIndexHelper = $this->goodHelper;

        $inputSortableParamaters = $goodIndexHelper->getInputSortableParameters();
        $inputSortableParamaters['limit'] = 15;
        $outputSortableParameters = $goodIndexHelper->getOutputSortableParameters($inputSortableParamaters);

        $sortableParameters = array_merge($inputSortableParamaters, $outputSortableParameters);

        return $sortableParameters;
    }

    public function getIndexxSortableParameters()
    {
        $indexxHelper = $this->indexxHelper;

        $inputSortableParamaters = $indexxHelper->getInputSortableParameters();
        $inputSortableParamaters['limit'] = 15;
        $outputSortableParameters = $indexxHelper->getOutputSortableParameters($inputSortableParamaters);

        $sortableParameters = array_merge($inputSortableParamaters, $outputSortableParameters);

        return $sortableParameters;
    }

    public function getHeader($saleHeaderId)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $saleHeader = $em->getRepository('AppBundle:SaleHeader')->getOne($workshop, $saleHeaderId);

        return $saleHeader;
    }

    public function setIndexxUnitPriceNet(TradeDetailInterface $detail)
    {

        $indexx = $detail->getIndexx();

        if(null !== $indexx->getUnitPriceNet())
        {
           return $detail;
        }

        $unitPriceNet = $detail->getUnitPriceNet();

        $indexx->setUnitPriceNet($unitPriceNet);

        return $detail;
    }


    /**
     * @param SaleDetail $detail
     * @param Good $prevGood|null
     * @return SaleDetail
     */
    public function setQuantity(TradeDetailInterface $detail, $prevGood, $prevIndexxQty)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        $detailQty = $detail->getQuantity();

        $indexx = $detail->getIndexx();
        $good = $indexx->getGood();

        $indexxQty = $indexx->getQuantity();
        $goodQty = $good->getQuantity();

        $diffIndexxQty = round($indexxQty - $prevIndexxQty, 2);

        if($diffIndexxQty != 0)
        {
            $this->indexxHelper->setIndexxEdit($indexx, $prevIndexxQty);
        }

        if($good === $prevGood)
        {
            $indexx->setQuantity($indexxQty - $detailQty);
            $good->setQuantity($goodQty + $diffIndexxQty - $detailQty);
        }
        else
        {
            $prevGood->setQuantity($prevGood->getQuantity() - $prevIndexxQty);

            $em->persist($prevGood);

            $indexx->setQuantity($indexxQty - $detailQty);
            $good->setQuantity($goodQty + $indexxQty - $detailQty);
        }

        $indexx->setGood($good);
        $detail->setIndexx($indexx);

        return $detail;
    }

    public function evaluateHeader(TradeHeaderInterface $tradeHeader, Collection $details)
    {
        $totalNetBeforeDiscount = 0;
        $discount = 0;
        $totalNet = 0;
        $vat      = 0;
        $totalDue = 0;

        /** @var TradeDetailInterface $detail */
        foreach($details as $detail)
        {
            if(null === $detail->getDeletedAt() && null === $detail->getRemovedAt())
            {
                $totalNetBeforeDiscount +=  $detail->getTotalNetBeforeDiscount();
                $discount               +=  $detail->getDiscount();
                $totalNet               +=  $detail->getTotalNet();
                $vat                    +=  $detail->getVat();
                $totalDue               +=  $detail->getTotalDue();
            }
        }

        $tradeHeader->setTotalNetBeforeDiscount($totalNetBeforeDiscount);
        $tradeHeader->setDiscount($discount);
        $tradeHeader->setTotalNet($totalNet);
        $tradeHeader->setVat($vat);
        $tradeHeader->setTotalDue($totalDue);

        return $tradeHeader;
    }
}