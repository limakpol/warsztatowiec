<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 11/2/17
 * Time: 7:03 PM
 */

namespace OrderBundle\Service\Helper;


use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class OrderHelper
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

    public function getOrderHeader($orderHeaderId)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $orderHeader = $this->entityManager->getRepository('AppBundle:OrderHeader')->getOne($workshop, $orderHeaderId);

        return $orderHeader;
    }

    public function getWorkstations($orderHeaderId)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $workstations = $this->entityManager->getRepository('AppBundle:Workstation')->retrieve($workshop);

        return $workstations;
    }
}