<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 11/4/17
 * Time: 11:01 PM
 */

namespace OrderBundle\Service\Helper;

use AppBundle\Entity\Action;
use AppBundle\Entity\Address;
use AppBundle\Entity\CarModel;
use AppBundle\Entity\Customer;
use AppBundle\Entity\OrderAction;
use AppBundle\Entity\OrderHeader;
use AppBundle\Entity\OrderIndexx;
use AppBundle\Entity\OrderSymptom;
use AppBundle\Entity\User;
use AppBundle\Entity\Vehicle;
use AppBundle\Entity\Workshop;
use AppBundle\Service\Trade\Trade;
use CustomerBundle\Service\Helper\CustomerAddHelper;
use CustomerBundle\Service\Helper\CustomerIndexHelper;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use OrderBundle\Form\OrderActionType;
use OrderBundle\Form\OrderHeaderAddType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use VehicleBundle\Service\Helper\VehicleAddHelper;
use VehicleBundle\Service\Helper\VehicleIndexHelper;

class OrderActionHelper
{
    private $requestStack;
    private $tokenStorage;
    private $formFactory;
    private $entityManager;
    private $trade;

    public function __construct(RequestStack $requestStack, TokenStorageInterface $tokenStorage, FormFactoryInterface $formFactory, EntityManagerInterface $entityManager, Trade $trade)
    {
        $this->requestStack     = $requestStack;
        $this->tokenStorage     = $tokenStorage;
        $this->formFactory      = $formFactory;
        $this->entityManager    = $entityManager;
        $this->trade            = $trade;
    }

    public function getOrderHeader($orderHeaderId)
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

    public function getOrderIndexx($orderIndexxId)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $orderIndexx = $em->getRepository('AppBundle:OrderIndexx')->getOne($workshop, $orderIndexxId);

        return $orderIndexx;
    }

    public function createForm()
    {
        $orderAction = new OrderAction();

        $form = $this->formFactory->create(OrderActionType::class, $orderAction, [
            'validation_groups' => ['order_action_add', 'action'],
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

            /** @var OrderAction $orderAction */
            $orderAction = $form->getData();

            if($orderAction->getAction() === null && !$request->get('order_action')['action_name'])
            {
                $error = new FormError('Nazwa nowej usługi nie może być pusta');

                $form->get('action_name')->addError($error);
            }

            return $form->isValid();
        }

        return false;
    }

    public function write(Form $form, OrderIndexx $orderIndexx)
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var OrderAction $orderAction */
        $orderAction = $form->getData();

        $dateTime = new \DateTime();

        $orderAction->setOrderIndexx($orderIndexx);
        $orderIndexx->addOrderAction($orderAction);
        $orderAction->setCreatedAt($dateTime);
        $orderAction->setCreatedBy($user);
        $orderAction->setUpdatedBy($user);

        $action = $orderAction->getAction();

        if(null === $action)
        {
            $actionName = $request->get('order_action')['action_name'];

            $action = $em->getRepository('AppBundle:Action')->getOneByName($workshop, $actionName);

            if(null === $action)
            {
                $action = $em->getRepository('AppBundle:Action')->getOneRemovedByName($workshop, $actionName);
            }

            if(null === $action)
            {
                $action = new Action();
                $action->setWorkshop($workshop);
                $action->setCreatedAt($dateTime);
                $action->setCreatedBy($user);
                $action->setUpdatedBy($user);
                $action->setName($actionName);
            }

            $action->setRemovedAt(null);
            $action->setDeletedAt(null);

            $orderAction->setAction($action);
        }

        $orderAction = $this->trade->evaluateDetail($orderAction);
        $orderHeader = $orderIndexx->getOrderHeader();
        $orderHeader = $this->trade->evaluateOrderHeader($orderHeader);

        $orderAction = $this->assignWorkmans($orderAction);

        $em->persist($action);
        $em->persist($orderAction);
        $em->persist($orderIndexx);
        $em->persist($orderHeader);

        $em->flush();

        return true;
    }

    public function assignWorkmans(OrderAction $orderAction)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $workmans = $orderAction->getWorkmans()->toArray();

        $orderAction->getWorkmans()->clear();

        foreach($workmans as $workmanId)
        {
            $workman = $em->getRepository('AppBundle:User')->getOne($workshop, $workmanId);

            if(null !== $workman)
            {
                $orderAction->addWorkman($workman);
            }
        }

        return $orderAction;
    }
}