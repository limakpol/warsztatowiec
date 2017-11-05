<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 11/5/17
 * Time: 2:55 AM
 */

namespace CustomerBundle\Service\Helper;

use AppBundle\Entity\Customer;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CustomerShowHelper
{
    private $requestStack;
    private $tokenStorage;
    private $formFactory;
    private $entityManager;

    public function __construct(RequestStack $requestStack, TokenStorageInterface $tokenStorage, FormFactoryInterface $formFactory, EntityManagerInterface $entityManager)
    {
        $this->requestStack     = $requestStack;
        $this->tokenStorage     = $tokenStorage;
        $this->formFactory      = $formFactory;
        $this->entityManager    = $entityManager;
    }

    public function getCustomer($customerId)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $customer = $em->getRepository('AppBundle:Customer')->getOne($workshop, $customerId);

        return $customer;
    }

    public function getOrderHeaders(Customer $customer)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $orderHeaders = $em->getRepository('AppBundle:OrderHeader')->retrieveByCustomer($workshop, $customer);

        return $orderHeaders;
    }

    public function getDeliveryHeaders(Customer $customer)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $deliveryHeaders = $em->getRepository('AppBundle:DeliveryHeader')->retrieveByCustomer($workshop, $customer);

        return $deliveryHeaders;
    }

    public function getSaleHeaders(Customer $customer)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $saleHeaders = $em->getRepository('AppBundle:SaleHeader')->retrieveByCustomer($workshop, $customer);

        return $saleHeaders;
    }
}