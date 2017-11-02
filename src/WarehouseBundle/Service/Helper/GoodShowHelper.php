<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 10/24/17
 * Time: 5:13 PM
 */

namespace WarehouseBundle\Service\Helper;

use AppBundle\Entity\Good;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class GoodShowHelper
{
    private $requestStack;
    private $tokenStorage;
    private $entityManager;

    public function __construct(RequestStack $requestStack, TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager)
    {
        $this->requestStack     = $requestStack;
        $this->tokenStorage     = $tokenStorage;
        $this->entityManager    = $entityManager;
    }

    public function getGood($goodId)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $good = $this->entityManager->getRepository('AppBundle:Good')->getOne($workshop, $goodId);

        return $good;
    }

    public function getDeliveryDetails(Good $good)
    {

        /** @var EntityManager $em */
        $em = $this->entityManager;
        
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $deliveryDetails = $em->getRepository('AppBundle:DeliveryDetail')->getByGood($workshop, $good);  
        
        return $deliveryDetails;
    }

    public function getSaleDetails(Good $good)
    {

        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $saleDetails = $em->getRepository('AppBundle:SaleDetail')->getByGood($workshop, $good);

        return $saleDetails;
    }

    public function getOrderIndexxes(Good $good)
    {

        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $orderIndexxes = $em->getRepository('AppBundle:OrderIndexx')->getByGood($workshop, $good);

        return $orderIndexxes;
    }

    public function getIndexxEdits(Good $good)
    {

        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $indexxEdits = $em->getRepository('AppBundle:IndexxEdit')->getByGood($workshop, $good);

        return $indexxEdits;
    }



}