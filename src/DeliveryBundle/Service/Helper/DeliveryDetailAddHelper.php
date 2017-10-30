<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 10/25/17
 * Time: 1:48 PM
 */

namespace DeliveryBundle\Service\Helper;

use AppBundle\Entity\DeliveryDetail;
use AppBundle\Entity\DeliveryHeader;
use AppBundle\Entity\Good;
use AppBundle\Entity\Indexx;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use AppBundle\Service\Trade\Trade;
use DeliveryBundle\Form\DeliveryDetailAddType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use WarehouseBundle\Service\Helper\GoodHelper;
use WarehouseBundle\Service\Helper\IndexxHelper;

class DeliveryDetailAddHelper
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

    public function prepareFormData()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $deliveryDetail = new DeliveryDetail();

        $indexxId   = $request->get('delivery_detail_add')['indexx_id'];
        $goodId     = $request->get('delivery_detail_add')['indexx']['good_id'];
        $goodName     = $request->get('delivery_detail_add')['indexx']['good']['name'];

        /** @var Indexx $indexx */
        $indexx = $em->getRepository('AppBundle:Indexx')->getOne($workshop, $indexxId);

        /** @var Good $good */
        $good   = $em->getRepository('AppBundle:Good')->getOne($workshop, $goodId);

        $prevGood = null;

        if(null === $indexx)
        {

            $indexx = new Indexx();
        }
        else
        {
            $prevGood = $indexx->getGood();
        }

        if(null === $good)
        {
            $good = $em->getRepository('AppBundle:Good')->getOneByName($workshop, $goodName);

            if(null === $good)
            {
                $good = new Good();
            }
        }

        $indexx->setGood($good);

        $deliveryDetail->setIndexx($indexx);

        return [
            'deliveryDetail' => $deliveryDetail,
            'prevGood' => $prevGood,
        ];
    }

    public function createForm(DeliveryDetail $deliveryDetail)
    {
        $form = $this->formFactory->create(DeliveryDetailAddType::class, $deliveryDetail, [
            'validation_groups' => ['delivery_detail_add', 'good', 'indexx'],
        ]);

        return $form;
    }

    public function isValid(Form $form)
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        if($request->isMethod('POST'))
        {
            $form->submit($request->request->get($form->getName()));

            return $form->isValid();
        }

        return false;
    }


    public function write(Form $form, DeliveryHeader $deliveryHeader, $prevGood)
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var DeliveryDetail $deliveryDetail */
        $deliveryDetail = $form->getData();

        $dateTime = new \DateTime();

        $deliveryDetail->setDeliveryHeader($deliveryHeader);
        $deliveryDetail->setCreatedAt($dateTime);
        $deliveryDetail->setCreatedBy($user);
        $deliveryDetail->setUpdatedBy($user);

        $indexx = $deliveryDetail->getIndexx();
        $good = $indexx->getGood();

        if(null === $deliveryDetail->getIndexxId())
        {
            $indexx->setCreatedAt($dateTime);
            $indexx->setCreatedBy($user);
            $indexx->setUpdatedBy($user);
        }

        if(null === $indexx->getGoodId())
        {
            $good->setWorkshop($workshop);
            $good->setCreatedAt($dateTime);
            $good->setCreatedBy($user);
            $good->setUpdatedBy($user);
        }

        if($deliveryDetail->getAutocomplete())
        {
            $deliveryDetail = $this->trade->evaluateDetail($deliveryDetail);
        }
        else
        {
            $deliveryDetail = $this->trade->normalizeDetail($deliveryDetail);
        }

        $deliveryDetail = $this->setIndexxUnitPriceNet($deliveryDetail);

        if($deliveryHeader->getAutocomplete())
        {
            $deliveryHeader = $this->trade->addDetail($deliveryHeader, $deliveryDetail);
        }

        $deliveryDetail = $this->setQuantity($deliveryDetail, $prevGood);

        $good = $this->assignCarModels($good);
        $good = $this->assignCategories($good);

        $em->persist($good);
        $em->persist($indexx);
        $em->persist($deliveryDetail);
        $em->persist($deliveryHeader);

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

    public function getHeader($deliveryHeaderId)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $deliveryHeader = $em->getRepository('AppBundle:DeliveryHeader')->getOne($workshop, $deliveryHeaderId);

        return $deliveryHeader;
    }

    public function setIndexxUnitPriceNet(DeliveryDetail $deliveryDetail)
    {
        if(!$deliveryDetail->getQuantity())
        {
            return $deliveryDetail;
        }

        $indexx = $deliveryDetail->getIndexx();

        if(null !== $indexx->getUnitPriceNet())
        {
           return $deliveryDetail;
        }

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $marginPc = $workshop->getParameters()->getGoodMarginPc();

        $unitPriceNet = $deliveryDetail->getTotalDue() / $deliveryDetail->getQuantity();

        $unitPriceNet += (($marginPc / 100) * $unitPriceNet);

        $indexx->setUnitPriceNet($unitPriceNet);

        return $deliveryDetail;
    }


    /**
     * @param DeliveryDetail $deliveryDetail
     * @param Good $prevGood|null
     * @return DeliveryDetail
     */
    public function setQuantity(DeliveryDetail $deliveryDetail, $prevGood)
    {

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $indexx = $deliveryDetail->getIndexx();
        $good = $indexx->getGood();

        $detailQty = $deliveryDetail->getQuantity();
        $indexxQty = $indexx->getQuantity();
        $goodQty = $good->getQuantity();

        $prevQty = $prevGood instanceof Good ? $prevGood->getQuantity() : 0;

        if(null === $deliveryDetail->getIndexxId())
        {
            $indexx->setQuantity($indexxQty + $detailQty);
            $good->setQuantity($goodQty + $detailQty);
        }
        else
        {
            if(null === $indexx->getGoodId())
            {
                $prevGood->setQuantity($prevQty - $indexxQty);

                $em->persist($prevGood);

                $indexx->setQuantity($indexxQty + $detailQty);
                $good->setQuantity($goodQty + $indexxQty + $detailQty);
            }
            else
            {
                if($good === $prevGood)
                {
                    $indexx->setQuantity($indexxQty + $detailQty);
                    $good->setQuantity($goodQty + $detailQty);
                }
                else
                {
                    $prevGood->setQuantity($prevQty - $indexxQty);

                    $em->persist($prevGood);

                    $indexx->setQuantity($indexxQty + $detailQty);
                    $good->setQuantity($goodQty + $indexxQty + $detailQty);
                }
            }
        }

        $indexx->setGood($good);
        $deliveryDetail->setIndexx($indexx);

        return $deliveryDetail;
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