<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 10/25/17
 * Time: 1:48 PM
 */

namespace OrderBundle\Service\Helper;

use AppBundle\Entity\IndexxEdit;
use AppBundle\Entity\OrderIndexx;
use AppBundle\Entity\OrderHeader;
use AppBundle\Entity\Good;
use AppBundle\Entity\Indexx;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use AppBundle\Service\Trade\Trade;
use OrderBundle\Form\OrderIndexxAddType;
use Doctrine\ORM\EntityManager;
use SaleBundle\Service\Helper\SaleDetailAddHelper;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use WarehouseBundle\Service\Helper\GoodHelper;
use WarehouseBundle\Service\Helper\IndexxHelper;

class OrderIndexxAddHelper
{
    private $requestStack;
    private $tokenStorage;
    private $entityManager;
    private $formFactory;
    private $goodHelper;
    private $indexxHelper;
    private $trade;
    private $saleDetailAddHelper;

    public function __construct(RequestStack $requestStack, TokenStorageInterface $tokenStorage, EntityManager $entityManager, FormFactoryInterface $formFactory, GoodHelper $goodHelper, IndexxHelper $indexxHelper, Trade $trade, SaleDetailAddHelper $saleDetailAddHelper)
    {
        $this->requestStack     = $requestStack;
        $this->tokenStorage     = $tokenStorage;
        $this->entityManager    = $entityManager;
        $this->formFactory      = $formFactory;
        $this->goodHelper       = $goodHelper;
        $this->indexxHelper     = $indexxHelper;
        $this->trade            = $trade;
        $this->saleDetailAddHelper = $saleDetailAddHelper;
    }

    public function write(Form $form, OrderHeader $orderHeader, $prevGood, $prevIndexxQty)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var OrderIndexx $orderIndexx */
        $orderIndexx = $form->getData();

        $dateTime = new \DateTime();

        $orderIndexx->setOrderHeader($orderHeader);
        $orderHeader->addOrderIndexx($orderIndexx);
        $orderIndexx->setCreatedAt($dateTime);
        $orderIndexx->setCreatedBy($user);
        $orderIndexx->setUpdatedBy($user);

        $indexx = $orderIndexx->getIndexx();
        $good   = $indexx->getGood();

        $orderIndexx = $this->trade->evaluateDetail($orderIndexx);
        $orderIndexx = $this->saleDetailAddHelper->setIndexxUnitPriceNet($orderIndexx);
        $orderIndexx = $this->saleDetailAddHelper->setQuantity($orderIndexx, $prevGood, $prevIndexxQty);

        $orderHeader = $this->saleDetailAddHelper->evaluateHeader($orderHeader, $orderHeader->getOrderIndexxes());

        $good = $this->goodHelper->assignCategories($good);
        $good = $this->goodHelper->assignCarModels($good);

        $em->persist($good);
        $em->persist($indexx);
        $em->persist($orderIndexx);
        $em->persist($orderHeader);

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

    public function getHeader($orderHeaderId)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $orderHeader = $em->getRepository('AppBundle:OrderHeader')->getOne($workshop, $orderHeaderId);

        return $orderHeader;
    }

}