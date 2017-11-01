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

        $saleHeader = $this->evaluateHeader($saleHeader);

        $good = $this->assignCarModels($good);
        $good = $this->assignCategories($good);

        $em->persist($good);
        $em->persist($indexx);
        $em->persist($saleDetail);
        $em->persist($saleHeader);

        $em->flush();

        return true;
    }

    public function setIndexxEdit(Indexx $indexx, $prevIndexxQty)
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $diffQty = round($indexx->getQuantity() - $prevIndexxQty, 2);

        $indexxEdit = new IndexxEdit();
        $indexxEdit->setCreatedAt(new \DateTime());
        $indexxEdit->setCreatedBy($user);
        $indexxEdit->setWorkshop($workshop);
        $indexxEdit->setIndexx($indexx);
        $indexxEdit->setBeforeQty($prevIndexxQty);
        $indexxEdit->setAfterQty($indexx->getQuantity());
        $indexxEdit->setChangeQty($diffQty);

        $em->persist($indexxEdit);

        return;
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

    public function setIndexxUnitPriceNet(SaleDetail $saleDetail)
    {

        $indexx = $saleDetail->getIndexx();

        if(null !== $indexx->getUnitPriceNet())
        {
           return $saleDetail;
        }

        $unitPriceNet = $saleDetail->getUnitPriceNet();

        $indexx->setUnitPriceNet($unitPriceNet);

        return $saleDetail;
    }


    /**
     * @param SaleDetail $saleDetail
     * @param Good $prevGood|null
     * @return SaleDetail
     */
    public function setQuantity(SaleDetail $saleDetail, $prevGood, $prevIndexxQty)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        $detailQty = $saleDetail->getQuantity();

        $indexx = $saleDetail->getIndexx();
        $good = $indexx->getGood();

        $indexxQty = $indexx->getQuantity();
        $goodQty = $good->getQuantity();

        $diffIndexxQty = round($indexxQty - $prevIndexxQty, 2);

        if($diffIndexxQty != 0)
        {
            $this->setIndexxEdit($indexx, $prevIndexxQty);
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
        $saleDetail->setIndexx($indexx);

        return $saleDetail;
    }

    public function evaluateHeader(SaleHeader $saleHeader)
    {

        $totalNetBeforeDiscount = 0;
        $discount = 0;
        $totalNet = 0;
        $vat      = 0;
        $totalDue = 0;


        /** @var SaleDetail $saleDetail */
        foreach($saleHeader->getSaleDetails() as $saleDetail)
        {
            if(null === $saleDetail->getDeletedAt() && null === $saleDetail->getRemovedAt())
            {
                $totalNetBeforeDiscount +=  $saleDetail->getTotalNetBeforeDiscount();
                $discount               +=  $saleDetail->getDiscount();
                $totalNet               +=  $saleDetail->getTotalNet();
                $vat                    +=  $saleDetail->getVat();
                $totalDue               +=  $saleDetail->getTotalDue();
            }
        }

        $saleHeader->setTotalNetBeforeDiscount($totalNetBeforeDiscount);
        $saleHeader->setDiscount($discount);
        $saleHeader->setTotalNet($totalNet);
        $saleHeader->setVat($vat);
        $saleHeader->setTotalDue($totalDue);

        return $saleHeader;
    }

    public function assignCarModels(Good $good)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $carModels = $good->getCarModels()->toArray();

        $good->getCarModels()->clear();

        foreach($carModels as $carModelId)
        {
            $carModel = $em->getRepository('AppBundle:CarModel')->getOne($workshop, $carModelId);

            if(null !== $carModel)
            {
                $good->addCarModel($carModel);
            }
        }

        return $good;
    }

    public function assignCategories(Good $good)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $categories = $good->getCategories()->toArray();

        $good->getCategories()->clear();

        foreach($categories as $categoryId)
        {
            $category = $em->getRepository('AppBundle:Category')->getOne($workshop, $categoryId);

            if(null !== $category)
            {
                $good->addCategory($category);
            }
        }

        return $good;
    }
}