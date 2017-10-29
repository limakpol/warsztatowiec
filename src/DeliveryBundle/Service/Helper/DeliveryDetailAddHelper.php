<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 10/25/17
 * Time: 1:48 PM
 */

namespace DeliveryBundle\Service\Helper;

use AppBundle\Entity\DeliveryDetail;
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

    public function createForm()
    {

        $deliveryDetail = new DeliveryDetail();

        $form = $this->formFactory->create(DeliveryDetailAddType::class, $deliveryDetail, [
            'validation_groups' => ['delivery_detail_add'],
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


    public function write(Form $form)
    {
        /** @var DeliveryDetail $deliveryDetail */
        $deliveryDetail = $form->getData();


        var_dump($deliveryDetail);
        die();

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

    public function headerExists($deliveryHeaderId)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $deliveryHeader = $em->getRepository('AppBundle:DeliveryHeader')->getOne($workshop, $deliveryHeaderId);

        return null !== $deliveryHeader;
    }
}